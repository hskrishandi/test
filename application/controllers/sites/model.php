<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class model extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('template_inheritance', 'html', 'form', 'url', 'download', 'file'));
    }

    public function index()
    {
        $this->load->view('vue/model/index');
    }
}
