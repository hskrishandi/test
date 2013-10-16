<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class search extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->helper(array('template_inheritance', 'html', 'credits', 'form', 'url'));
		$this->load->model(array('Account_model', 'Resources_model'));
		//$this->load->library('session');
		$this->load->driver('session');
		$this->config->load('home');
	}

	public function index()
	{
		$this->load->view('search/search');
	}
}