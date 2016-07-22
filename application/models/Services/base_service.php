<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

interface ServiceInterface {
    public function getById($id);
}

/**
 * Base Service
 */
abstract class Base_service extends CI_Model implements ServiceInterface
{
    public function __construct()
    {
        parent::__construct();
    }
}
