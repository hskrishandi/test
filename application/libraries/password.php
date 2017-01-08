<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Password
{
    public $pass;

    public function __construct($password = null)
    {
        require_once dirname(__FILE__) . '/password.inc';
        $this->pass = $password;
    }

    /**
     * Check if the two passwords are match
     *
     * @param $encrypted
     * @return bool
     *
     * @author Leon
     */
    public function isMatch($plain, $encrypted = null)
    {
        if ($encrypted != null) {
            $this->pass = $encrypted;
        }
        return user_check_password($plain, $this);
    }
}
