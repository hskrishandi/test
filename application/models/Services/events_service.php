<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Events service.
 */
class Events_service extends Base_service
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Repositories/Events_repository');
    }

    /**
     * Get by id
     *
     * @param $id
     * @return $event
     *
     * @author Leon
     */
    public function getById($id)
    {
        return $this->Events_repository->getById($id);
    }

    /**
     * Get events by options
     *
     * @param $count, $page
     * @return $events
     *
     * @author Leon
     */
    public function getByOptions($count, $page)
    {
        return $this->Events_repository->getByOptions($count, $count * ($page - 1));
    }

    /**
     * Get all upcoming events
     *
     * @return $events
     *
     * @author Leon
     */
    public function getUpcoming()
    {
        return $this->Events_repository->getUpcoming();
    }

    /**
     * Get past events by options
     *
     * @param $count, $page
     * @return $events
     *
     * @author Leon
     */
    public function getPastByOptions($count, $page)
    {
        return $this->Events_repository->getPastByOptions($count, $count * ($page - 1));
    }
}
