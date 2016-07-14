<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class simulation extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('html');
    }

    public function index()
    {
        $this->load->view('vue/simulation/index');
    }
}
