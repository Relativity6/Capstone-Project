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

    // Delete member function not complete
}
