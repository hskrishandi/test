<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class contributors extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->helper('template_inheritance');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->database();
        $this->load->model('Simulation_model');
    }

    /**
     * Show the contributors page.
     *
     * @return view
     *
     * @author Leon
     */
    public function index()
    {
        $this->load->view('contributors/index');
    }
}
