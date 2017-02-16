<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Organizations_service extends Base_service
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Repositories/Organizations_repository');
    }

    /**
     * Get Organizations
     *
     * @return Organizations
     *
     * @author Alex
     */
    public function getByOptions($count, $page)
    {
        return $this->Organizations_repository->getByOptions($count, $count * ($page - 1));
    }
}