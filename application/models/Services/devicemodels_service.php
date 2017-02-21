<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * This is a template service for example, showing you how to write a service.
 */
class DeviceModels_service extends Base_service
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Repositories/DeviceModels_repository');
    }

    /**
     * Get all device models.
     *
     * @return all device models
     *
     * @author Leon
     */
    public function getByOptions($count, $page)
    {
        return $this->DeviceModels_repository->getByOptions($count, $count * ($page - 1));
    }
}
