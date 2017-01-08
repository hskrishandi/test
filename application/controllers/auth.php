<?php

// ini_set('display_errors', 'On');

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Auth Controller.
 */
class auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Services/Auth_service');
        $this->load->helper('json');
        $this->load->helper('error');
    }

    /**
     * Login
     *
     * @param $email $password
     * @return login result
     *
     * @author Leon
     */
    public function login()
    {
        $email = $this->input->post('email');
        $password= $this->input->post('password');
        if ($email && $password) {
            $result = $this->Auth_service->login($email, $password);
        } else {
            $result = getError('input', 'Invalid input');
        }
        outputJson($result);
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
        $email = $this->input->post('email');
        if ($email) {
            $result = $this->Auth_service->logout($email);
        } else {
            $result = getError('input', 'Invalid input');
        }
        outputJson($result);
    }

    /**
     * Check is login
     * Not sure we will need this for auth controller
     *
     * @param $token
     * @return login result
     *
     * @author Leon
     */
    public function _isLogin()
    {
        $token = $this->input->post('token');
        if ($token) {
            //
            $result = $this->Auth_service->isLogin($token);
        } else {
            $result = getError('input', 'Invalid input');
        }
        outputJson($result);
    }
}
