<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class home extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->helper(array('template_inheritance', 'html', 'credits', 'form', 'url'));
		$this->load->model(array('Account_model', 'Resources_model'));
		//$this->load->library('session');
		$this->load->driver('session');
		$this->config->load('home');
	}

	/**
	 * Home Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://www.i-mos.org/home
	 *	- or -  
	 * 		http://www.i-mos.org/home/index
	 */
	public function index()
	{
		$data = array(
			'activities' => $this->Resources_model->get_activities_adv('undelete',3),
			'user_experience' => $this->Resources_model->get_user_experience()
		);
		$this->load->view('home/index', $data);
	}
		
	public function activities()
	{
		$data = array(		
			'activities' => $this->Resources_model->get_activities_adv('undelete')
		);

		$this->load->view('home/activities', $data);
	}
		
	public function user_experience()
	{
		$data = array(		
			'user_experience' => $this->Resources_model->get_user_experience(20)
		);
		
		$this->load->view('home/user_experience', $data);
	}
		
	public function post_experience()
	{
		if (!$this->Account_model->isAuth()) return;
		
		$user_id = $this->Account_model->islogin()->id;
		$data = array();
		$this->load->library('form_validation');
		
		if ($this->input->post()) {
			$config = $this->config->item('post_exp_form_config');

			$this->form_validation->set_rules($config); 
			
			if ($this->form_validation->run()) {
				$this->Resources_model->add_user_experience($user_id, $this->input->post('comment'));
				$this->session->native->set_flashdata('post_experience_msg', 'Your comment is submited. Thank you.');
				redirect(current_url());
			}
		}
		
		$data['msg'] = $this->session->native->flashdata('post_experience_msg');
		
		$this->load->view('home/post_experience', $data);
	}

	public function manual()
	{
		$this->load->helper('download');
		force_download('i-MOS Users Manual.pdf', file_get_contents('files/manual/i-mos manual_1st rev.pdf'));
	}

}

/* End of file home.php */
/* Location: ./application/controllers/home.php */
