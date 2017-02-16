<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * API Controller.
 */
class contacts extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Services/Contacts_service');
    }

    /**
     * Contact us
     *
     * @param $email, $name, $affiliation, $subject, $message
     * @return response
     *
     * @author Leon
     */
    public function createContact()
    {
        // TODO: Should add protection to prevent attach. e.g.recaptcha
        if ($this->method == "POST") {
            $email = $this->input->post('email');
            $name = $this->input->post('name');
            $affiliation = $this->input->post('affiliation') ?: "";
            $subject = $this->input->post('subject');
            $message = $this->input->post('message');
            if ($email && $name && $subject && $message) {
                $this->body = $this->Contacts_service->createContact($email, $name, $affiliation, $subject, $message);
            } else {
                $this->status = 406;
            }
        } else {
            $this->status = 405;
        }
        $this->response();
    }
}
