<?php

class Session {
    public $id;
    public $fname;

    public function __construct()
    {
        session_start();
        $this->id = $_SESSION['id'] ?? 0;
        $this->fname = $_SESSION['fname'] ?? '';
    }

    public function create($member)
    {
        session_regenerate_id(true);
        $_SESSION['id'] = $member['id'];
        $_SESSION['fname'] = $member['fname'];
    }

    public function update($member)
    {
        $this->create($member);
    }

    public function delete()
    {
        $_SESSION = [];
        $param = session_get_cookie_params();
        setcookie(session_name(), '', time() - 2400, $param['path'], $param['domain'], $param['secure'], $param['httponly']);
        session_destroy();
    }
}
