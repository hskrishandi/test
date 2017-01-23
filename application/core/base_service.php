<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * This is a base service, it provides some standard functions.
 * Service is used for logical operations.
 */
abstract class Base_service extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get by id.
     *
     * @param $id
     *
     * @author Leon
     */
    // abstract protected function getById($id);
}
