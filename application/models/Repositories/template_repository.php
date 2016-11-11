<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * This is a template repository, showing you how to write a repository.
 */
class Template_repository extends CI_Model
{
    /**
     * This is a example function.
     *
     * @param $param
     *
     * @return $value
     *
     * @author Leon
     */
    public function example($param)
    {
        // Retrieve data from database using sql
        return 'Data retrieved from database';
    }
}
