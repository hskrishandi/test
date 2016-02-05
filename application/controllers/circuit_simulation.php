<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Circuit_simulation extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->helper('template_inheritance');
		$this->load->helper('url');
		$this->load->helper('html');
	}	
	
	

	public function index()
{
	$this->load->view('circuit_simulation/index');
	
}

}
?>