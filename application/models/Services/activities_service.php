<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Activities service.
 */
class Activities_service extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Repositories/Activities_repository');
    }

    /**
     * Get activities.
     *
     * @param count
     *
     * @return activities
     *
     * @author Leon
     */
    public function getActivities($count)
    {
        return $this->Activities_repository->getActivities($count);
    }
}
