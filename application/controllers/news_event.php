<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class news_event extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->helper(array('template_inheritance', 'html', 'url', 'date'));						
		$this->load->model('Resources_model');
		$this->load->model('Account_model');		
		$this->config->load('news_event');
		$this->load->library('pagination');
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
		$num_rows = RESOURCE_INDEX_ENTRIES_PER_BLOCK;
		$data = array(	
				'past_events' => $this->Resources_model->get_events_adv('undelete',true, $num_rows),
				'upcoming_events' => $this->Resources_model->get_events_adv('undelete',false, $num_rows),
				'groups' => $this->Resources_model->get_groups_adv('undelete',$num_rows),
				'articles' => $this->Resources_model->get_articles_adv('undelete','all', $num_rows),
				'models' => $this->Resources_model->get_models_adv('undelete','released', $num_rows),
				'news' => $this->Resources_model->get_news_adv('undelete',$num_rows),
				'tools' => $this->Resources_model->get_tools_adv('undelete', 'all', $num_rows),		
						
		);
		
		$this->load->view('news_event/index', $data);
	}
	
	public function events()
	{		
			$data = array(	
					'userInfo' => $this->Account_model->isLogin(),
					'past_events' => $this->Resources_model->get_events_adv('undelete',true, RESOURCE_ENTRIES_PER_PAGE),
					'upcoming_events' => $this->Resources_model->get_events_adv('undelete',false, RESOURCE_ENTRIES_PER_PAGE)
			);					


		$this->load->view('news_event/events', $data);
	}


	public function approve_event($event_id=0){
		if (!$this->Account_model->isAuth()) return;
		if($event_id>0){
			$this->Resources_model->approve_event($event_id);
			redirect(base_url('/news_event/events/'.$event_id), 'refresh');
		}
		else{
			show_404();	
		}
	}
		
	
				
	public function news($id = 0)
	{	
		if ($id > 0) {
			$data = array('display_list' => false,
			'userInfo' => $this->Account_model->isLogin(),
			'news_details' => $this->Resources_model->get_news_details($id), 
			'news_status'=>$this->Resources_model->check_inapproavl_news($id));
			
		} else {
		$page=($this->uri->segment(3))?$this->uri->segment(3):0;
			$data = array(		
				'display_list' => true,
				'userInfo' => $this->Account_model->isLogin(),
				'news' => $this->Resources_model->get_news_adv('undelete'),
				'links'=>$this->pagination->create_links()
			);

			
			
		} 
		$this->load->view('news_event/news', $data);
	}
	
	public function approve_news($news_id){
		if (!$this->Account_model->isAuth()) return;
		$this->Resources_model->approve_news($news_id);
		redirect(base_url('/news_event/news/'.$news_id), 'refresh');
		
	}
	
	
	
	public function maintain(){
		//if($this->Account_model->isLogin()->email=='model@i-mos.org'){
		if($this->Account_model->isLogin()->class >= 99){
			redirect(base_url('/news_event/'), 'refresh');
		}
		if(!isset($_GET['action'])){
			show_404();	
		}
		
		
		$action=$_GET['action'];
		
		if($action=='del'){
				if(isset($_GET['newsid'])){
					$newsId=$_GET['newsid'];
					if($newsId <=0){
						show_404();
					}
					$this->Resources_model->delNews($newsId);
					redirect(base_url('/news_event/news/'), 'refresh');
				}
				
		}
		
	}

	
	

}

/* End of file resources.php */
/* Location: ./application/controllers/resources.php */
