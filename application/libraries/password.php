<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Password
{
    public $pass;

    public function __construct($password = null)
    {
		require_once dirname(__FILE__) . '/bootstrap.inc';
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

    /**
     * Encrypt password
     *
     * @param plain text password
     * @return encrypted password
     *
     * @author Leon
     */
    public function encrypt($password = null)
    {
        if ($password != null) {
            $this->pass = $password;
        }
        return _password_crypt('sha512', $this->pass, _password_generate_salt(DRUPAL_HASH_COUNT));
    }
}
