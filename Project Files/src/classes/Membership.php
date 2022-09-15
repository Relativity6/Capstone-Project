<?php

class Membership
{
    protected $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    // Join a group. Args array holds [user_id, group_id, role]
    public function joinGroup(array $args): bool
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

    // Checks if user is in a specific group.
    // (group.php)
    public function isMember(int $user_id, int $group_id)
    {
        $sql = "SELECT id
                FROM membership
                WHERE user_id = :user_id AND group_id = :group_id;";

        return $this->db->runSql($sql, ['user_id' => $user_id, 'group_id' => $group_id])->fetch();
    }

    // Get groups that the user is a member of. Returns array of group ID's or false if no groups are found.
    // (dashboard.php)
    public function memberOf(int $id)
    {
        $sql = "SELECT group_id
                FROM membership
                WHERE user_id = :id AND role = 'member';";

        $groups = $this->db->runSql($sql, [$id])->fetch();

        if (!$groups) {
            return false;
        }

        else {
            return $groups;
        }
    }

    // Get groups that the user is admin of. Returns array of group ID's or false if no groups are found.
    // (dashboard.php)
    public function adminOf(int $id)
    {
        $sql = "SELECT group_id
                FROM membership
                WHERE user_id = :id AND role = 'admin';";

        $groups = $this->db->runSql($sql, [$id])->fetch();

        if (!$groups) {
            return false;
        }

        else {
            return $groups;
        }
    }

    // Get all members of a group.  Returns array of members or false if no members are found.
    // (group.php)
    public function getMembers(int $group_id)
    {
        $sql = "SELECT user_id
                FROM membership
                WHERE group_id = :group_id AND role = 'member';";

        $members = $this->db->runSql($sql, [$group_id])->fetchAll();

        if (!$members) {
            return false;
        }

        else {
            return $members;
        }
    }

    // Get admin of a group. Returns User ID of admin.
    // (group.php)
    public function getAdmin(int $group_id)
    {
        $sql = "SELECT user_id
                FROM membership
                WHERE group_id = :group_id AND role = 'admin';";

        $admin = $this->db->runSql($sql, [$group_id])->fetch();
        return $admin;
    }

}
