<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Organizations extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Services/Organizations_service');
    }

    /**
     * Get tools
     *
     * @author Leon
     */
    public function getTools()
    {
        if ($this->method = 'GET') {
            $count = $this->validateInteger($this->input->get('count'), 5);
            $page = $this->validateInteger($this->input->get('page'), 1);
            $this->body = $this->Organizations_service->getByOptions($count, $page);
        } else {
            $this->status = 405;
        }
        $this->response();
    }
}