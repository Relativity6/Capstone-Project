<?php

class Membership
{
    protected $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    // Create new Membership object.  Args array holds [user_id, group_id, role]
    public function create(array $args): bool
    {
        try {
            $sql = "INSERT INTO membership (user_id, group_id, role)
                    VALUES (:user_id, :group_id, :role);";
            $this->db->runSql($sql, $args);
            return true;
        }

        catch(PDOException $e) {
            throw $e;
            return false;
        }
    }

    // Get groups that the user is a member of. Returns array of group ID's or false if no groups are found.
    public function memberOf(int $id)
    {
        $sql = "SELECT group_id
                FROM membership
                WHERE user_id = :id AND role = 'member';";
        $groups = $this->db->runSql($sql, [$id]);

        if (!$groups) {
            return false;
        }

        else {
            return $groups;
        }
    }

    // Get groups that the user is admin of. Returns array of group ID's or false if no groups are found.
    public function adminOf(int $id)
    {
        $sql = "SELECT group_id
                FROM membership
                WHERE user_id = :id AND role = 'admin';";
        $groups = $this->db->runSql($sql, [$id]);

        if (!$groups) {
            return false;
        }

        else {
            return $groups;
        }
    }
}
