<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class resources extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->helper(array('template_inheritance', 'html', 'url', 'date'));						
		$this->load->model('Resources_model');
		$this->load->model('Account_model');		
		$this->config->load('resources');
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
				/*'past_events' => $this->Resources_model->get_events_adv('undelete',true, $num_rows),
				'upcoming_events' => $this->Resources_model->get_events_adv('undelete',false, $num_rows),*/
				'groups' => $this->Resources_model->get_groups_adv('undelete',$num_rows),
				'articles' => $this->Resources_model->get_articles_adv('undelete','all', $num_rows),
				'models' => $this->Resources_model->get_models_adv('undelete','released', $num_rows),
				/*'news' => $this->Resources_model->get_news_adv('undelete',$num_rows),*/
				'tools1' => $this->Resources_model->get_tools_adv('undelete', 'device_sim', $num_rows),
				'tools2' => $this->Resources_model->get_tools_adv('undelete', 'circuit_sim', $num_rows),
				'tools3' => $this->Resources_model->get_tools_adv('undelete', 'param_extract', $num_rows),
				'tools4' => $this->Resources_model->get_tools_adv('undelete', 'interface', $num_rows)
						
		);
		
		$this->load->view('resources/index', $data);
	}
	
	public function events()
	{		
			$data = array(	
					'userInfo' => $this->Account_model->isLogin(),
					'past_events' => $this->Resources_model->get_events_adv('undelete',true, RESOURCE_ENTRIES_PER_PAGE),
					'upcoming_events' => $this->Resources_model->get_events_adv('undelete',false, RESOURCE_ENTRIES_PER_PAGE)
			);					


		$this->load->view('resources/events', $data);
	}


	public function approve_event($event_id=0){
		if (!$this->Account_model->isAuth()) return;
		if($event_id>0){
			$this->Resources_model->approve_event($event_id);
			redirect(base_url('/resources/events/'.$event_id), 'refresh');
		}
		else{
			show_404();	
		}
	}
		
	public function articles($id=0)
	{	

			if($id>0){
				$data = array('display_list' => false,
				'userInfo' => $this->Account_model->isLogin(),
				'articles_details' => $this->Resources_model->get_articles_details($id));		
			}
			
			else{
			$articles = array();
			foreach ($this->config->item('article_types') as $year => $name) {
				$articles[$name] = $this->Resources_model->get_articles_adv('undelete',$year, RESOURCE_ENTRIES_PER_PAGE);
			}
			
			$data = array(	
				'display_list' => true,
				'userInfo'=>$this->Account_model->isLogin(),
				'articles' => $articles);
			}

		$this->load->view('resources/articles', $data);
	}
	
	public function approve_article($article_id=0){
		if (!$this->Account_model->isAuth()) return;
		if($article_id>0){
			$this->Resources_model->approve_article($article_id);
			redirect(base_url('/resources/articles/'.$article_id), 'refresh');
		}
		else{
			show_404();
		}
				
	}
	
	public function groups()
	{

			$data = array(	
					'groups' => $this->Resources_model->get_groups_adv('undelete',RESOURCE_ENTRIES_PER_PAGE), 
					'userInfo' => $this->Account_model->isLogin()
			);


		$this->load->view('resources/groups', $data);	
	}
	public function approve_group($group_id){
		if (!$this->Account_model->isAuth()) return;
		$this->Resources_model->approve_group($group_id);
		redirect(base_url('/resources/groups/'), 'refresh');
		
	}	
	public function models()
	{

			$models = array();
			foreach ($this->config->item('device_model_status') as $type => $title) {
				$models[$title] = $this->Resources_model->get_models_adv('undelete',$type, RESOURCE_ENTRIES_PER_PAGE);
			}
			
			$data = array(	
				'models' => $models,
				'userInfo' => $this->Account_model->isLogin()
			);
		

		$this->load->view('resources/models', $data);
	}
	public function approve_model($model_id){
		if (!$this->Account_model->isAuth()) return;
		$this->Resources_model->approve_model($model_id);
		redirect(base_url('/resources/models'), 'refresh');		
	}
				
	public function news($id = 0)
	{	
		if ($id > 0) {
			$data = array('display_list' => false,
			'userInfo' => $this->Account_model->isLogin(),
			'news_details' => $this->Resources_model->get_news_details($id), 
			'news_status'=>$this->Resources_model->check_inapproavl_news($id));
			
		} else {
		
			$data = array(		
				'display_list' => true,
				'userInfo' => $this->Account_model->isLogin(),
				'news' => $this->Resources_model->get_news_adv('undelete',RESOURCE_ENTRIES_PER_PAGE)
			);

			
			
		} 
		$this->load->view('resources/news', $data);
	}
	
	public function approve_news($news_id){
		if (!$this->Account_model->isAuth()) return;
		$this->Resources_model->approve_news($news_id);
		redirect(base_url('/resources/news/'.$news_id), 'refresh');
		
	}
	
	public function edit_resources($res=NULL){
		//if($this->Account_model->isLogin()->email=='model@i-mos.org'){
		if($this->Account_model->isLogin()->class >= 99){
			redirect(base_url('/resources/'), 'refresh');
		}
		
		if($res==NULL){
			show_404();		
		}
		else{
			
			if($res=='news'){	
				$news_id=$this->input->get_post('newsid', TRUE);
				if ($news_id > 0) {
					$data = array('res' =>$res,
					'userInfo' => $this->Account_model->isLogin(),
					'news_details' => $this->Resources_model->get_news_details($news_id));
					$this->load->view('resources/edit_resources',$data);				
				}
				else{
				show_404();	
				}
			}
			else if ($res=='events'){
				$event_id=$this->input->get_post('eventid', TRUE);
				if ($event_id > 0) {
					$data = array('res' =>$res,
					'userInfo' => $this->Account_model->isLogin(),
					'event_details' => $this->Resources_model->get_event_by_id($event_id));	
					$this->load->view('resources/edit_resources',$data);			
				}
				else{
				show_404();	
				}
								
			}
			else if ($res=='articles'){
				$article_id=$this->input->get_post('articleid', TRUE);
				if ($article_id > 0) {
					$data = array('res' =>$res,
					'userInfo' => $this->Account_model->isLogin(),
					'article_details' => $this->Resources_model->get_articles_details($article_id));
					$this->load->view('resources/edit_resources',$data);				
				}
				else{
				show_404();	
				}				
			}
			else if ($res=='groups'){
				$group_id=$this->input->get_post('groupid', TRUE);
				if ($group_id > 0) {
					$data = array('res' =>$res,
					'userInfo' => $this->Account_model->isLogin(),
					'group_details' => $this->Resources_model->get_groups_details($group_id));
					$this->load->view('resources/edit_resources',$data);				
				}
				else{
				show_404();	
				}				
			}	
			else if ($res=='models'){
				$model_id=$this->input->get_post('modelid', TRUE);
				if ($model_id > 0) {
					$data = array('res' =>$res,
					'userInfo' => $this->Account_model->isLogin(),
					'model_details' => $this->Resources_model->get_models_by_id($model_id));
					$this->load->view('resources/edit_resources',$data);				
				}
				else{
				show_404();	
				}				
			}
			else if ($res=='tools'){
				$tool_id=$this->input->get_post('toolid', TRUE);
				if ($tool_id > 0) {
					$data = array('res' =>$res,
					'userInfo' => $this->Account_model->isLogin(),
					'tool_details' => $this->Resources_model->get_tools_by_id($tool_id));
					$this->load->view('resources/edit_resources',$data);				
				}				
			}
		}

	}
	public function edit_resources_submit($res){
		//if($this->Account_model->isLogin()->email=='model@i-mos.org'){
		if($this->Account_model->isLogin()->class >= 99){
			redirect(base_url('/resources/'), 'refresh');
		}
		if($res!=NULL){
			if($res=='news'){
				$news_id=$this->input->get_post('newsid', TRUE);	
				$title=$this->input->get_post('title', TRUE);
				$content=$this->input->get_post('content', TRUE);
				$slink = $this->input->get_post('slink', TRUE);
				$this->Resources_model->edit_news($news_id,$title,$slink, $content);
				redirect(base_url('cms/resources/news/?id='.$news_id), 'refresh');			
			}
			else if($res=='events'){

				$events_id=$this->input->get_post('eventid', TRUE);	
				$data = array(	
				'name'=>$this->input->get_post('name', TRUE),
				'full_name'=>$this->input->get_post('full_name', TRUE),
				'start_date'=>$this->input->get_post('start_date', TRUE),
				'end_date'=>$this->input->get_post('end_date', TRUE),
				'location'=>$this->input->get_post('location', TRUE),
				'website'=>$this->input->get_post('website', TRUE)
				);
				$this->Resources_model->edit_event($data,$events_id);
				redirect(base_url('/cms/resources'), 'refresh');

							
			}				
			else if($res=='articles'){
				$article_id=$this->input->get_post('articleid', TRUE);
				$data = array(	
				'name'=>$this->input->get_post('name', TRUE),
				'author'=>$this->input->get_post('author', TRUE),
				'publisher'=>$this->input->get_post('publisher', TRUE),
				'year'=>$this->input->get_post('year', TRUE),
				'website'=>$this->input->get_post('website', TRUE),
				'summary'=>$this->input->get_post('summary', TRUE),
				'article_name' =>$this->input->get_post('article_name', TRUE),
				'article_link' =>$this->input->get_post('article_link', TRUE)
				);
				$this->Resources_model->edit_article($data,$article_id);
				redirect(base_url('/cms/resources'), 'refresh');			
			}
			else if($res=='groups'){
				$group_id=$this->input->get_post('groupid', TRUE);
				$data = array(	
				'name'=>$this->input->get_post('name', TRUE),
				'website'=>$this->input->get_post('website', TRUE),
				);
				$this->Resources_model->edit_group($data,$group_id);
				redirect(base_url('/cms/resources'), 'refresh');			
			}
			else if($res=='models'){
				$model_id=$this->input->get_post('modelid', TRUE);
				$data = array(	
				'author'=>$this->input->get_post('author', TRUE),
				'name'=>$this->input->get_post('name', TRUE),
				'status'=>$this->input->get_post('status', TRUE),
				'website'=>$this->input->get_post('website', TRUE),
				);
				$this->Resources_model->edit_model($data,$model_id);
				redirect(base_url('/cms/resources'), 'refresh');			
			}
			else if($res=='tools'){
				$tool_id=$this->input->get_post('toolid', TRUE);
				$data = array(	
				
				'name'=>$this->input->get_post('name', TRUE),
				'description'=>$this->input->get_post('description', TRUE),
				'type'=>$this->input->get_post('type', TRUE),
				'website'=>$this->input->get_post('website', TRUE),
				);
				$this->Resources_model->edit_tool($data,$tool_id);
				redirect(base_url('/cms/resources'), 'refresh');			
			}				
		}
		
	}
	
	
	public function tools()
	{
		if($this->Account_model->isLogin()&&$this->Account_model->isLogin()->class >= 99){
			$tools = array();
			foreach ($this->config->item('tool_type') as $type => $title) {
				$tools[$title] = $this->Resources_model->get_tools_adv('undelete',$type, RESOURCE_ENTRIES_PER_PAGE);
			}
			
			$data = array(
				
				'userInfo' => $this->Account_model->isLogin(),	
				'tools' => $tools
			);
		}
		else{
			$tools = array();
			foreach ($this->config->item('tool_type') as $type => $title) {
				$tools[$title] = $this->Resources_model->get_tools_adv('undelete',$type, RESOURCE_ENTRIES_PER_PAGE);
			}
			
			$data = array(	
				'userInfo' => $this->Account_model->isLogin(),
				'tools' => $tools
			);			
		}

		$this->load->view('resources/tools', $data);
	}
	
	public function approve_tool($tools_id){
		if (!$this->Account_model->isAuth()) return;
		$this->Resources_model->approve_tool($tools_id);
		redirect(base_url('/resources/tools/'), 'refresh');		
	}	
	
	public function post($res){
		if (!$this->Account_model->isAuth()) return;
		if($res!=NULL){
			$data = array(
			'res' =>$res);
			$this->load->view('resources/post',$data);
		}
		else {
			redirect(base_url('/resources/'), 'refresh');
		}
	}
	
	public function submit($res){
		//if($this->Account_model->isLogin()->email=='model@i-mos.org'){
		if($this->Account_model->isLogin()->class >= 99){
			$approval_status = 1;
		}
		else{
			$approval_status = 0;	
		}
		
		if($res=='news'){
			
			$data = array(
				'title' => $this->input->get_post('title', TRUE),
				'content' => $this->input->get_post('content', TRUE),
				'post_date' => $this->input->get_post('post_date', TRUE),
				'source_link' => $this->input->get_post('slink', TRUE),
				'approval_status' => $approval_status
			);
				
			$this->Resources_model->insertNews($data);	
			redirect(base_url('/resources/post/submited?res='.$res), 'refresh');	
		}
		else if($res=='events'){
			$data = array(
				'name' => $this->input->get_post('name', TRUE),
				'full_name' => $this->input->get_post('full_name', TRUE),
				'start_date' => $this->input->get_post('start_date', TRUE),
				'end_date' => $this->input->get_post('end_date', TRUE),
				'location' => $this->input->get_post('location', TRUE),
				'website' => $this->input->get_post('website', TRUE),
				'approval_status' => $approval_status
			);
			$this->Resources_model->insertEvents($data);
			redirect(base_url('/resources/post/submited?res='.$res), 'refresh');	
		}
		else if($res=='articles'){
			$data = array(
				'name' => $this->input->get_post('name', TRUE),
				'author' => $this->input->get_post('author', TRUE),
				'publisher' => $this->input->get_post('publisher', TRUE),
				'year' => $this->input->get_post('year', TRUE),
				'summary' => $this->input->get_post('summary', TRUE),
				'website' => $this->input->get_post('website', TRUE),
				'type' => 'books',
				'approval_status' => $approval_status
			);
			$this->Resources_model->insertArticles($data);	
			redirect(base_url('/resources/post/submited?res='.$res), 'refresh');					
		}
		else if($res=='groups'){
			$data = array(
				'name' => $this->input->get_post('name', TRUE),
				'website' => $this->input->get_post('website', TRUE),
				'approval_status' => $approval_status
			);
			$this->Resources_model->insertGroups($data);
			redirect(base_url('/resources/post/submited?res='.$res), 'refresh');		
		}
		else if($res=='models'){
			$data = array(
				'name' => $this->input->get_post('name', TRUE),
				'author' => $this->input->get_post('author', TRUE),
				'website' => $this->input->get_post('website', TRUE),
				'status' => $this->input->get_post('status', TRUE),
				'approval_status' => $approval_status
			);
			$this->Resources_model->insertModels($data);	
			redirect(base_url('/resources/post/submited?res='.$res), 'refresh');				
		}
		else if($res=='tools'){
			$data = array(
				'name' => $this->input->get_post('name', TRUE),
				'description' => $this->input->get_post('description', TRUE),				
				'website' => $this->input->get_post('website', TRUE),
				'type' => $this->input->get_post('type', TRUE),
				'approval_status' => $approval_status
			);
			$this->Resources_model->insertTools($data);
			redirect(base_url('/resources/post/submited?res='.$res), 'refresh');				
		}
		// Inserting new activities
		else if ($res == 'activities') {
			//load data from post request
			$data = array(
				'content' => $this->input->get_post('activities_content', true),
				'approval_status' => $approval_status,
				'del_status' => false
			);
			//insert
			$this->Resources_model->insertActivities($data);
			//redirect to 'done' message page
			redirect(base_url('/resources/post/submited?res='.$res), 'refresh');				
		}
	}
	
	public function maintain(){
		//if($this->Account_model->isLogin()->email=='model@i-mos.org'){
		if($this->Account_model->isLogin()->class >= 99){
			redirect(base_url('/resources/'), 'refresh');
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
					redirect(base_url('/resources/news/'), 'refresh');
				}
				else if(isset($_GET['articleid'])){
					$article_id=$_GET['articleid'];
					if($article_id <=0){
						show_404();
					}
					$this->Resources_model->del_article($article_id);
					redirect(base_url('/resources/articles/'), 'refresh');
				}
				else if(isset($_GET['groupid'])){
					$group_id=$_GET['groupid'];
					if($group_id <=0){
						show_404();
					}
					$this->Resources_model->del_group($group_id);
					redirect(base_url('/resources/groups/'), 'refresh');
				}	
				else if(isset($_GET['modelid'])){
					$model_id=$_GET['modelid'];
					if($model_id <=0){
						show_404();
					}
					$this->Resources_model->del_model($model_id);
					redirect(base_url('/resources/models/'), 'refresh');
				}
				else if(isset($_GET['toolid'])){
					$tool_id=$_GET['toolid'];
					if($tool_id <=0){
						show_404();
					}
					$this->Resources_model->del_tool($tool_id);
					redirect(base_url('/resources/tools/'), 'refresh');
				}						
		}
		
	}

	
	

}

/* End of file resources.php */
/* Location: ./application/controllers/resources.php */
