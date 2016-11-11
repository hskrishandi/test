<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * User Service.
 */
class User_service extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Repositories/User_repository');
        $this->load->helper('url');
    }

    /**
     * Get user by Id.
     *
     * @param  $id
     *
     * @author Leon
     */
    public function getById($id)
    {
        //TODO
        return;
    }

    /**
     * Get user experience.
     *
     * @param  $count, $offset
     *
     * @return
     *
     * @author Leon
     */
    public function getUserExperience($count)
    {
        $experiences = $this->User_repository->getUserExperience($count);

        return $experiences;
    }
}
