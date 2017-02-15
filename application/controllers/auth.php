<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Auth Controller.
 */
class auth extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->config->load('account_create_form');
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
     * @param register data
     *
     * @author Leon
     */
    public function register()
    {
        if ($this->method == "POST") {
            // Form validation
            $form = $this->config->item('account_create_form');
            $this->form_validation->set_rules($form);
            $valid = $this->form_validation->run();
            if ($valid) {
                // Valid input
                foreach ($form as $key) {
                    $registerData[$key['field']] = $this->input->post($key['field']);
                }
                $this->body = $this->Auth_service->register($registerData);
            } else {
                // Invalid input
                $this->status = 400;
            }
        } else {
            $this->status = 405;
        }
        $this->response();
    }

    /**
     * Reset passord
     *
     * @param type $param
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
     * @param $uuid
     *
     * @author Leon
     */
    public function activate($uuid)
    {
        // User will click the activation email, so it will be a 'GET' mehod
        if ($this->method == "GET") {
                // TODO: Should do some redirect to frontend
            $this->body = $this->Auth_service->activateAccount($uuid);
        } else {
            $this->status = 405;
        }
        $this->response();
    }
}
