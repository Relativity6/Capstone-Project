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

        $groups = $this->db->runSql($sql, [$id])->fetchAll();

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

        $groups = $this->db->runSql($sql, [$id])->fetchAll();

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

    public function getMembersAndAdmin(int $group_id)
    {
        $sql = "SELECT user_id
                FROM membership
                WHERE group_id = :group_id AND (role = 'member' OR role = 'admin');";
        return $this->db->runSql($sql, [$group_id])->fetchAll();
    }

    // Get the admin and all members of a group, excluding the user
    // (alert.php)
    public function getAllBesidesUser(int $group_id, int $user_id)
    {
        $sql = "SELECT user_id
                FROM membership
                WHERE group_id = :group_id AND (role = 'member' OR role = 'admin') AND NOT user_id = :user_id;";
        return $this->db->runSql($sql, ['group_id' => $group_id, 'user_id' => $user_id])->fetchAll();
    }

    // Return the number of people in a group
    // (Dashboard.php)
    public function getNumberOfMembers(int $group_id): int
    {
        $sql = "SELECT user_id
                FROM membership
                WHERE group_id = :group_id AND (role = 'member' OR role = 'admin');";
        
        $members = $this->db->runSql($sql, [$group_id])->fetchAll();
        
        if (!$members) {
            return 0;
        }
        else {
            return sizeof($members);
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

    // Remove a member from a group
    // (edit_group.php)
    public function removeMember(int $member_id, int $group_id): bool
    {
        $sql = "DELETE
                FROM membership
                WHERE user_id = :user_id AND group_id = :group_id;";
        
        try {
            $this->db->runsql($sql, ['user_id' => $member_id, 'group_id' => $group_id]);
            return true;
        }

        catch(PDOException $e) {
            throw $e;
            return false;
        }
    }

}
