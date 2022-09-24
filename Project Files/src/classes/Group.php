<?php

class Group
{
    protected $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function get(int $id)
    {
        $sql = "SELECT name, password, admin_id
                FROM groups
                WHERE id = :id;";

        return $this->db->runSQL($sql, [$id])->fetch();
    }

    public function getByGroupName(string $group_name)
    {
        $sql = "SELECT id, name, password, admin_id
                FROM groups
                WHERE name = :name;";

        return $this->db->runSql($sql, [$group_name])->fetch();
    }

    // Create new group. Args array holds [name, password, admin_id]
    // Returns true if new group created. Returns false if uniqueness constraint violated
    public function create(array $args): bool
    {
        // Hash password
        $args['password'] = password_hash(($args['password']), PASSWORD_DEFAULT);

        try {
            $sql = "INSERT INTO groups (name, password, admin_id)
                    VALUES (:name, :password, :admin_id);";
            $this->db->runSql($sql, $args);
            return true;
        }

        catch(PDOException $e) {
            // If a uniqueness constraint is violated (Group name), return false
            if ($e->errorInfo[1] === 2601) {
                return false;
            }
            throw $e;
        }
    }

    public function delete(int $id)
    {
        
        try {
            $sql = "DELETE FROM groups
                    WHERE id = :id;";
            $this->db->runSql($sql, [$id]);
            return true;
        }

        catch(PDOException $e) {
            throw $e;
            return false;
        }
    }
}
