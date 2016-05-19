<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class welcome extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->helper('template_inheritance');
        $this->load->helper('html');
        $this->load->helper('url');
        $this->load->helper('date');
        $this->load->helper('credits_helper');
        $this->load->helper('recaptchalib_helper');
        $this->load->model('Account_model');
        $this->load->library('form_validation');

        $this->config->load('account_create_form');
        $this->config->load('account_info_update');
    }
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
        // $this->load->view('welcome_message');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
