<?php
namespace Capstone\CMS;

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

    public function create(array $member): bool
    {
        $member['password'] = password_hash(($member['password']), PASSWORD_DEFAULT);

        try {
            $sql = "INSERT INTO members (fname, lname, email, password, profile_pic, phone_num)
                    VALUES (:fname, :lname, :email, :password, :profile_pic, :phone_num);";
            $this->db->runSql($sql, $member);
            return true;
        }

        catch (\PDOException $e) {
            if ($e->errorInfo[1] === 1062) {
                return false;
            }
            throw $e;
        }
    }
}