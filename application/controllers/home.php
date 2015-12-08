<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * The default Contoller of i-MOS
 */
class home extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->helper(array('template_inheritance', 'html', 'credits', 'form', 'url'));
		$this->load->model(array('Account_model', 'Resources_model', 'Modelsim_model'));
		$this->load->library('session');
		//$this->load->library('MY_Session');
		//$this->load->driver('session');
		$this->config->load('home');
	}

	/**
	 * Default Page for this controller.
	 * @link http://www.i-mos.org/
	 * @return view: home/index
	 */
	public function index()
	{
		// Load list of activities and user experience from Resources_model to be show on the view
		$data = array(
			'activities' => $this->Resources_model->get_activities_adv('undelete',6),
			'user_experience' => $this->Resources_model->get_user_experience(),
			'top_models' => $this->Modelsim_model->getTopModels()
		);
		// Load and show home/index view
		$this->load->view('home/index', $data);
	}
	
	/**
	 * More i-MOS Activities Page.
	 * @link http://i-mos.org/imos/home/activities
	 * @return view: home/activities
	 */
	public function activities()
	{
		$data = array(		
			'activities' => $this->Resources_model->get_activities_adv('undelete')
		);

		$this->load->view('home/activities', $data);
	}

	/**
	 * More User Experience Page.
	 * @link http://i-mos.org/imos/home/user_experience
	 * @return view: home/activities
	 */
	public function user_experience()
	{
		$data = array(		
			'user_experience' => $this->Resources_model->get_user_experience(20)
		);
		
		$this->load->view('home/user_experience', $data);
	}

	/**
	 * More User Experience Page.
	 * Display post form or handle psoted data
	 * @link http://i-mos.org/imos/home/user_experience
	 * @param post string $comment     comment of the user experience
	 * @param post bool $quote_auth    if the user authorize i-mos.org to use quote, display real name and organization on the i-mos.org website.
	 * @param post bool $contact_auth  if the user authorize i-mos.org to contact for further information.
	 * @return view: home/activities or controller: account/auth_err
	 */
	public function post_experience()
	{
		// Login required. If not logged in, page will redirect to /account/authErr by Account_model
		if (!$this->Account_model->isAuth()) return;
		
		$user_id = $this->Account_model->islogin()->id;
		$data = array();
		$this->load->library('form_validation');

		// if user pressed Submit button, handle post data
		if ($this->input->post()) {
			//form_validation library configuration
			$config = $this->config->item('post_exp_form_config'); //load with config/home when construct

			// set the rules for form validation
			$this->form_validation->set_rules($config); 
			
			// if the form valid
			if ($this->form_validation->run()) {
				//save to db
				$this->Resources_model->add_user_experience($user_id, $this->input->post('comment'));
				//set var to session
				$this->session->set_flashdata('post_experience_msg', 'Your comment is submited. Thank you.');
				//refresh the page to show successful message
				redirect(current_url());
			}
		}
		
		//read var from session
		$data['msg'] = $this->session->flashdata('post_experience_msg');
		
		// Load and show home/post_experience view
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
