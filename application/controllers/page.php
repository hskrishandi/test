<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class page extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->helper('template_inheritance');
		$this->load->helper('url');
		$this->load->helper('html');
		
		$this->load->database();
		$this->load->model('Simulation_model');
	}
	
	/**
	 * Home Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://www.i-mos.org/
	 *	- or -  
	 * 		http://www.i-mos.org/index
	 */
	public function index(){	
		redirect('/home','location');
	}
		
	public function terms()
    {
		$this->load->view('terms');
	}
	public function privacy()
    {
		$this->load->view('privacy');
	}
	public function disclaimers()
    {
		$this->load->view('disclaimers');
	}
	
	public function sitemap(){
		$data = array(
			'model_info'=>$this->Simulation_model->getModelList()		
		);
		$this->load->view('sitemap',$data);
	}
	
	public function d($id)
	{
		//Load page basic info.
		$data['base_url'] = base_url();
		
		//Load page content and page title
		@$query = $this->db->query('SELECT * FROM content WHERE id="'.mysql_real_escape_string($id).'"  LIMIT 1');
		if ($query->num_rows() > 0) {
			$row = $query->row();
			$data['title'] = $row->title;
			$data['content'] = $row->content;				
			$this->load->view('page_from_db',$data);
		} else {
			show_404('page');
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
