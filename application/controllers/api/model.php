<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Model API Controller.
 */
class model extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Services/ModelService');
    }

    /**
     * Get model for api.
     *
     * @return model Json
     *
     * @author Leon
     */
    public function getModel()
    {
        $result = $this->ModelService->getById(1);
        echo json_encode($result);
    }
}