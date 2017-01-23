<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * This is a base repository, it provides some standard functions.
 * Repository is using for direct data accessing.
 */
abstract class Base_repository extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
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
