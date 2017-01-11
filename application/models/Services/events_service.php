<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Events service.
 */
class Events_service extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Repositories/Events_repository');
    }

    /**
     * Get Events.
     *
     * @param count
     *
     * @return events
     *
     * @author Leon
     */
    public function getEvents($count = null)
    {
        return $this->Events_repository->getEvents($count);
    }
}
