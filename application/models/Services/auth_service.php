<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * This is a auth service.
 */
class Auth_service extends CI_Model
{

    /**
     * Logined user
     *
     * @var array
     */
    private $user = null;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Repositories/Auth_repository');
        $this->load->library('Password');
        $this->load->library('session');
    }

    /**
     * login.
     *
     * @param $email, $password
     *
     * @return login result
     *
     * @author Leon
     */
    public function login($email, $inputPassword)
    {
        $users = $this->Auth_repository->getAuthUserByEmail($email);
        $result = array();
        switch (count($users)) {
            case 0:
                // Not registered
                $result = array(401 => "Email and password are not matched.");
                break;
            case 1:
                // Registered user
                $this->user = current($users);
                // Using the Password library to check password
                $password = new Password($this->user->password);
                if ($password->isMatch($inputPassword)) {
                    // if password is match
                    if ($this->user->isactivated == '1') {
                        // auth success
                        // create a new session base on the auth user id
                        $this->session->set_userdata(array('id' => $this->user->id));
                        // get the session_id, this is token for the api
                        $token = $this->session->userdata['session_id'];
                        // destroy the session
                        $this->session->sess_destroy();
                        // save the token for user in database
                        $this->Auth_repository->saveToken($this->user->id, $token);
                        // return the token
                        $result = array('token' => $token);
                    } else {
                        // account not activated
                        $result = array(401 => "Account not activated.");
                    }
                } else {
                    // if password is not match
                    $result = array(401 => "Email and password are not matched.");
                }
                break;

            default:
                // Multiple user email, error
                $result = array(401 => "Account error.");
                break;
        }
        return $result;
    }

    /**
     * Logout
     *
     * @param $email
     * @return logout result
     *
     * @author Leon
     */
    public function logout()
    {
        // logout is required login, when checking isLogin using 'isLogin()',
        // the auth user would be set if auth, hence we only need
        // to use the id of auth user to logout
        $result = $this->user != null ? $this->Auth_repository->discardToken($this->user->id) : false;
        return $result;
    }

    /**
     * Check whether the user is logined.
     *
     * @param $token
     * @return bool
     *
     * @author Leon
     */
    public function isLogin($token)
    {
        if (!$this->user) {
            $users = $this->Auth_repository->fetchAuthUserByToken($token);
            if (count($users) == 1) {
                // Save the user info
                $this->user = current($users);
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
        // TODO: Should check whether this token is expired, need to add one
        // column 'update_at' in users table, check the time
        // and compare with now
        return false;
    }

    /**
     * Get logined user
     *
     * @return logined user
     *
     * @author Leon
     */
    public function getLoginedUser()
    {
        return $this->user;
    }
}
