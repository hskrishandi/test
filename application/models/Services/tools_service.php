<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Tools_service extends Base_service
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Repositories/Tools_repository');
    }

    /**
     * Get tools
     *
     * @return tools
     *
     * @author Leon
     */
    public function getByOptions($count, $page)
    {
        return $this->Tools_repository->getByOptions($count, $count * ($page - 1));
    }
}
