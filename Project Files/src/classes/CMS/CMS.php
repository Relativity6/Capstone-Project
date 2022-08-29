<?php
namespace Capstone\CMS;

class CMS
{
    protected $db                   = null;                                 // Stores reference to Database object
    protected $member               = null;                                 // Stores reference to Member object
    protected $group                = null;                                 // Stores reference to Group object
    protected $membership           = null;                                 // Stores reference to Membership object
    protected $session              = null;

    public function __construct($dsn, $username, $password)
    {
        $this->db = new Database($dsn, $username, $password);
    }

    public function getMember()
    {
        if ($this->member === null) {
            $this->member = new Member($this->db);
        }
        return $this->member;
    }

    // public function getGroup()
    // {
    //     if ($this->group === null) {
    //         $this->group = new Group($this->db);
    //     }
    //     return $this->group;
    // }

    // public function getMembership()
    // {
    //     if ($this->membership === null) {
    //         $this->membership = new Membership($this->db);
    //     }
    //     return $this->membership;
    // }

    // public function getSession()
    // {
    //     if ($this->session === null) {
    //         $this->session = new Session($this->db);
    //     }
    //     return $this->session;
    // }
}