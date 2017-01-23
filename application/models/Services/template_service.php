<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * This is a template service for example, showing you how to write a service.
 */
class Template_service extends Base_service
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Repositories/Template_repository');
    }

    /**
     * example.
     *
     * @param $param
     *
     * @return $value
     *
     * @author Leon
     */
    public function example($param)
    {
        // Get the data from repository and perform logic here
        return $this->Template_repository->example();
    }
}
