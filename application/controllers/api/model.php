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
        $this->load->model('Services/Model_service');
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
        $result = $this->Model_service->getById();
        echo json_encode($result);
    }

    /**
     * Get user library
     *
     * @return $value
     *
     * @author Leon
     */
    public function getUserModel()
    {

    }
}
