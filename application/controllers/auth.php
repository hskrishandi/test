<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Auth Controller.
 */
class auth extends REST_Controller
{
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
        if ($this->method == "POST") {
            $email = $this->input->post('email');
            $password= $this->input->post('password');
            if ($email && $password) {
                $this->body = $this->Auth_service->login($email, $password);
            } else {
                $this->status = 400;
            }
        } else {
            $this->status = 405;
        }
        $this->response();
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
        $this->requireAuth();
        if ($this->method == "DELETE") {
            $this->body = $this->Auth_service->logout();
        } else {
            $this->status = 405;
        }
        $this->response();
    }

    /**
     * Register
     *
     * @param $param
     * @return $value
     *
     * @author Leon
     */
    public function register()
    {
        // TODO: register
    }

    /**
     * Reset passord
     *
     * @param type $param
     * @return $value
     *
     * @author Leon
     */
    public function resetPassword()
    {
        // TODO: reset password
    }

    /**
     * Activate account
     *
     * @param type $param
     * @return $value
     *
     * @author Leon
     */
    public function activate()
    {
        // TODO: activate account
    }
}
