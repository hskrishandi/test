<?php

ini_set('display_errors', 'On');

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * User API Controller.
 */
class user extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Services/User_service');
    }

    /**
     * Get user experience.
     *
     * @return experience
     *
     * @author Leon
     */
    public function getUserExperience()
    {
        $result = $this->User_service->getUserExperience(2);
        echo json_encode($result);
    }
    
}
