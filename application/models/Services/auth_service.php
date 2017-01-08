<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * This is a auth service.
 */
class Auth_service extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Repositories/Auth_repository');
        $this->load->helper('error');
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
        $user = $this->Auth_repository->getAuthUserByEmail($email);
        $result = array();
        switch (count($user)) {
            case 0:
                // Not registered
                $result = getError('auth', 'This email has not registered');
                break;
            case 1:
                // Registered user
                $password = new Password($user[0]->password);
                if ($password->isMatch($inputPassword)) {
                    // if password is match
                    if ($user[0]->isactivated == '1') {
                        // auth success
                        // create a new session base on the auth user id
                        $this->session->set_userdata(array('id'=>$user[0]->id));
                        // get the session_id, this is token for the api
                        $token = $this->session->userdata['session_id'];
                        // destroy the session
                        $this->session->sess_destroy();
                        // save the token for user in database
                        $this->Auth_repository->saveToken($user[0]->id, $token);
                        // return the token
                        $result['token'] = $token;
                    } else {
                        // account not activated
                        $result = getError('auth', 'Account has not activated');
                    }
                } else {
                    // if password is not match
                    $result = getError('auth', 'Authentication fail');
                }
                break;

            default:
                // Multiple user email, error
                $result = getError('auth', 'Authentication fail');
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
    public function logout($email)
    {
        $user = $this->Auth_repository->getAuthUserByEmail($email);
        $result = array();
        if (count($user) == 1) {
            $result['success'] = $this->Auth_repository->discardToken($user[0]->id);
        } else {
            $result = getError('auth', 'Account error');
        }
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
        $user = $this->Auth_repository->fetchAuthUserByToken($token);
        // TODO: Should check whether this token is expired, need to add one
        // column 'update_at' in users table, check the time
        // and compare with now
        if (count($user) == 1) {
            return true;
        }
        return false;
    }
}
