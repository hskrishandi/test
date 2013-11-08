<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class developer extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->helper(array('template_inheritance', 'html', 'form', 'url'));
		//$this->load->driver('session');
		$this->load->library('session');
		$this->load->library('MY_Session');
	}

	public function index()
	{
    /*
		if (!$this->session->flashdata('developer_tos')) {
			redirect('developer/tos');
		}
    */
		$this->load->view('developer/message');
	}
	
	public function tos()
	{
		if ($this->input->post()) {
			if ($this->input->post('response') === "I Agree") {
				$this->session->set_flashdata('developer_tos', 1);
				redirect('developer');
			} else {
				redirect('');
			}
		}
		
		$this->load->view('developer/tos');
	}
	
	public function submit()
	{
		if ($this->input->post()) {
			redirect('developer');
		} else {
			redirect('developer');
		}
	}		
}

/* End of file developer.php */
/* Location: ./application/controllers/developer.php */
