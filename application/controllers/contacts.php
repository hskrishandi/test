<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class contacts extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->helper('template_inheritance');
		$this->load->helper('html');
		$this->load->helper('url');
		$this->load->helper('date');
		$this->load->helper('credits_helper');
		$this->load->helper('recaptchalib_helper');
		$this->load->model('Contacts_model');
		$this->config->load('contacts_form');
	}

	/**
	 * Home Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://www.i-mos.org/resources
	 *	- or -
	 * 		http://www.i-mos.org/resources/index
	 */
	public function index()
	{
		$data = NULL;
		$this->load->view('contacts', $data);
	}

	public function submit(){
		//Check the captcha image correct or not
        /* Remove captcha by leon
		$this->load->library('form_validation');
		$this->load->model('Contacts_model');
		$privatekey = "6LfKDtASAAAAAJ4tsQC3heEYHWofPt8oFpx19IKd";
		$resp = recaptcha_check_answer ($privatekey,
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);

			$form = $this->config->item('contacts_form');
			$this->form_validation->set_rules($form);
			$data_vaild = $this->form_validation->run();
		if (!$resp->is_valid) {
			// What happens when the CAPTCHA was entered incorrectly
				 $data['err'] = array('verification' => "Verification code wrong. Please enter again.");
				 $this->load->view('contacts', $data);
		} else {

			if ($data_vaild){
				$data['msg'] = "Your message is submited. Thanks for your feedback.";

						$this->Contacts_model->form_submit(	$this->input->post('name'),
													$this->input->post('aff'),
													$this->input->post('email'),
													$this->input->post('subject'),
													$this->input->post('msg')
												   );
				$this->load->view('contacts', $data);
			}else{
				$data = NULL;
				$this->load->view('contacts', $data);
			}
		}
        */
        $this->load->model('Contacts_model');
        $data['msg'] = "Your message is submited. Thanks for your feedback.";
        $this->Contacts_model->form_submit(
            $this->input->post('name'),
            $this->input->post('aff'),
            $this->input->post('email'),
            $this->input->post('subject'),
            $this->input->post('msg')
        );
        $this->load->view('contacts', $data);
	}

}

/* End of file resources.php */
/* Location: ./application/controllers/resources.php */
