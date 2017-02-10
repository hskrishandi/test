<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class deviceModels extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Services/DeviceModels_service');
    }

    /**
     * Get device models
     *
     * @author Leon
     */
    public function getDeviceModels()
    {
        if ($this->method = 'GET') {
            $count = $this->validateInteger($this->input->get('count'), 5);
            $page = $this->validateInteger($this->input->get('page'), 1);
            $this->body = $this->DeviceModels_service->getByOptions($count, $page);
        } else {
            $this->status = 405;
        }
        $this->response();
    }
}
