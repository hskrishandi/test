<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class starrating extends CI_Controller {

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

	/*
	starrating->rate() is the function for
	submiting the ranking by user via AJAX Program
	*/
	public function rate()
	{	
		$ratevalue = 0;
		if ($this->input->post('id') === false)
			return;
		if (is_numeric($this->input->post('value'))){
			$ratevalue = $this->input->post('value');
		}
		$acc = $this->Account_model->islogin();
		if ($acc === false){
			echo 'withoutLogin';
			return;
		} else{
			$this->Star_rating_model->rate($acc, $this->input->post('id'), $ratevalue);
			echo 'okay';
		}
	}
	public function readRate($name){
		echo "<form target='".site_url('starrating/rate')."' method='POST' >";
		for ($i=0.5; $i<=5; $i+=0.5){
			echo '<input name="'.$name.'" type="radio" class="wow {split:2}" value="'.$i.'"/>';
		}
		echo "</form>";
	}
	public function testa(){
		$data = NULL;
		$this->load->view('test', $data);
	}
	
	public function readRateAvgMake($id){
		echo round($this->Star_rating_model->readAvgRate($id)+0,1);
	}
}

/* End of file starrating.php */
/* Location: ./application/controllers/home.php */
