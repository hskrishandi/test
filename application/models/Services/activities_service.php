<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Activities service.
 */
class Activities_service extends Base_service
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Repositories/Activities_repository');
    }

    /**
     * Get by id
     *
     * @param $id
     * @return $activity
     *
     * @author Leon
     */
    public function getById($id)
    {
        return $this->Activities_repository->getById($id);
    }

    /**
     * Get latest activities by count
     *
     * @param $count
     * @return $activities
     *
     * @author Leon
     */
    public function getByOptions($count, $page)
    {
        return $this->Activities_repository->getByOptions($count, $count * ($page - 1));
    }
}
