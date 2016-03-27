<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class test extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('template_inheritance');
        $this->load->helper('html');
        $this->load->helper('url');
        $this->load->helper('date');
        $this->load->helper('credits_helper');
        $this->load->model('Account_model');
        $this->load->model('Star_rating_model');
    }

    /**
     * Load test index page
     */
    public function index()
    {
        $this->load->view('test/layout');
    }

    /**
     * Load test layout page
     */
    public function layout()
    {
        $this->load->view('test/layout');
    }


}
