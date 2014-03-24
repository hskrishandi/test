<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class home extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->helper(array('template_inheritance', 'html', 'credits', 'form', 'url'));
		$this->load->model(array('Account_model', 'Resources_model'));
		$this->load->library('session');
		$this->load->library('MY_Session');
		//$this->load->driver('session');
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
				$this->session->set_flashdata('post_experience_msg', 'Your comment is submited. Thank you.');
				redirect(current_url());
			}
		}
		
		$data['msg'] = $this->session->flashdata('post_experience_msg');
		
		$this->load->view('home/post_experience', $data);
	}

	public function manual()
	{
		$this->load->helper('download');
		force_download('i-MOS Users Manual.pdf', file_get_contents('files/manual/i-mos manual_1st rev.pdf'));
	}
	
	
	//This function provide download function for url http://i-mos.org/imos/home/iwcm2014
	public function iwcm2014()
	{
		$this->load->helper('download');
		force_download('IWCM2014_PresentationFiles.zip', file_get_contents('files/iwcm2014/IWCM2014_PresentationFiles.zip'));
	}
	
	/*This is a more general download function. You can do updated more easily with this one.
		The url format is i-mos.org/imos/home/download/[$foldername]/[$filename]
		 It needs two parameters:
			$foldername : the folder name that contains the desired file in ./files/, for example iwcm2014,
			$filename : the file name to be download in the folder(only the file name.).
			After you paste these two function to home.php at /local/html/imos/applications/controller/, the above two urls should work together. You can choose either url.
			http://i-mos.org/imos/home/download/iwcm2014/IWCM2014_PresentationFiles.zip
	*/
	public function download($foldername,$filename)
	{
		$foldername = urldecode($foldername); //replace %20 with normal space symbol.
		$filename = urldecode($filename);
		$this->load->helper('download');
		force_download($filename, file_get_contents('files/'.$foldername.'/'.$filename));
	}

}

/* End of file home.php */
/* Location: ./application/controllers/home.php */
