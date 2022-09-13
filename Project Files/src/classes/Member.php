<?php

class Member
{
    protected $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function get(int $id)
    {
        $sql = "SELECT fname, lname, email, password, profile_pic, phone_num
                FROM members
                WHERE id = :id;";
        return $this->db->runSQL($sql, [$id])->fetch();
    }

    public function create(array $member, string $temporary, string $destination): bool
    {
        $member['password'] = password_hash(($member['password']), PASSWORD_DEFAULT);

        try {
            $sql = "INSERT INTO members (fname, lname, email, password, profile_pic, phone_num)
                    VALUES (:fname, :lname, :email, :password, :profile_pic, :phone_num);";
            $this->db->runSql($sql, $member);
            return true;
        }

        catch (PDOException $e) {
            if (file_exists($destination)) {
                unlink($destination);
            }
            if ($e->errorInfo[1] === 1062) {
                return false;
            }
            throw $e;
        }
    }

    public function login(string $email, string $password)
    {
        $sql = "SELECT id, fname, lname, email, password, profile_pic, phone_num
                FROM members
                WHERE email = :email;";
        
        $member = $this->db->runSQL($sql, [$email])->fetch();
        
        if (!$member) {
            return false;
        }

        $authenticated = password_verify($password, $member['password']);
        return ($authenticated ? $member : false);
    }

    public function update(int $id, array $member): bool
    {
        // Remove Member array elements that cannot be edited by this function
        unset($member['email'], $member['password'], $member['profile_pic']);
        $fname = $member['fname'];
        $lname = $member['lname'];
        $phone_num = $member['phone_num'];

        // Update rest of elements with provided values
        $sql = "UPDATE members
                SET fname = :fname, lname = :lname, phone_num = :phone_num
                WHERE id = :id;";

        $this->db->runSql($sql, ['id' => $id, 'fname' => $fname, 'lname' => $lname, 'phone_num' => $phone_num]);
        return true;
    }

    public function changePicture(int $id, string $old_pic,  string $new_pic): bool
    {
        // Delete old picture
        $unlink = unlink('uploads/' . $old_pic);
        if ($unlink === false) {
            throw new Exception('Unable to delete image or image is missing');
        }
        
        // Update entry in Members table in DB
        $sql = "UPDATE members
                SET profile_pic = :new_pic
                WHERE id = :id;";
        $this->db->runSql($sql, ['new_pic' => $new_pic, 'id' => $id],);
        return true;
    }

    public function deleteMember(int $id, string $profile_pic): bool
    {
        // Delete profile picture form Uploads folder
        if ($profile_pic != 'Default.jpg') {
            $unlink = unlink('uploads/' . $profile_pic);

            if ($unlink === false) {
                throw new Exception('Unable to delete image or image is missing');
            }
        }
       
        // Delete member from database
        $sql = 'DELETE FROM members
                WHERE id = :id;';
        $this->db->runSql($sql, [$id]);
        return true;
    }
}
