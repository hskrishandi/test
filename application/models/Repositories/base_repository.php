<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

interface RepositoryInterface {
    public function getById($id);
}

/**
 * Base Repository
 */
abstract class Base_repository extends CI_Model implements RepositoryInterface
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
}
