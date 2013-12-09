<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class cms extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->helper(array('template_inheritance', 'html', 'url', 'date'));	
		$this->load->model('discussion_model');				
		$this->load->model('Resources_model');
		$this->load->model('Account_model');	
		$this->load->model('modelsim_model');	
		$this->load->model('server_model');
		$this->config->load('resources');
		$this->config->load('account_info_update');
		$this->load->library('form_validation');
		
		$this->config->load('account_create_form');
	}
	
	public function index()
	{	
		if (!$this->Account_model->isAuth()) return;
		if($this->Account_model->isLogin()->email!='model@i-mos.org') show_404();
		$data = array(
		"disapproved_res" => $this->Resources_model->countDisapporvedRes()
		);
		
			
		$this->load->view('cms/index',$data);
	}
	
	public function discussion($action=NULL){
		if (!$this->Account_model->isAuth()) return;
		if($this->Account_model->isLogin()->email!='model@i-mos.org') show_404();
		if($action == NULL){
		$data = array(	
			'posts' => $this->discussion_model->getPosts('all',NULL),
			'userInfo' => $this->Account_model->isLogin(),
			
		);	
		$this->load->view('cms/discussion',$data);	
		}
		else if($action=='hide_res'){
			$type=$this->input->get('type',TRUE);
			$id=$this->input->get('id',TRUE);				
			$this->discussion_model->hideRes(true,$type,$id,NULL);
					
		}
		else if($action=='unhide_res'){
			$type=$this->input->get('type',TRUE);
			$id=$this->input->get('id',TRUE);				
			$this->discussion_model->hideRes(false,$type,$id,NULL);
					
		}
		else if($action=='del_res'){
			$type=$this->input->get('type',TRUE);
			$id=$this->input->get('id',TRUE);	
			$this->discussion_model->delRes($type,$id,NULL);			
			
		}
	}

	public function resources($action=NULL){
		if (!$this->Account_model->isAuth()) return;
		if($this->Account_model->isLogin()->email!='model@i-mos.org') show_404();
		/* display all the resources */
		if($action == NULL){
			$data = array(
			'userInfo' => $this->Account_model->isLogin(),
			'news' => $this->Resources_model->get_news_adv('all'), 
			'past_events' => $this->Resources_model->get_events_adv('all',true, RESOURCE_ENTRIES_PER_PAGE),
			'coming_events' => $this->Resources_model->get_events_adv('all',false, RESOURCE_ENTRIES_PER_PAGE),
			'articles' => $this->Resources_model->get_articles_adv('all','all'),
			'groups' => $this->Resources_model->get_groups_adv('all'),
			'models' => $this->Resources_model->get_models_adv('all'),
			'tools' => $this->Resources_model->get_tools_adv('all', 'all', RESOURCE_ENTRIES_PER_PAGE),
			'user_experience' => $this->Resources_model->get_user_experience()
				
			);
		$this->load->view('cms/resources',$data);
		}
		else if($action == 'list_hidden_res'){

		}
		
		/* manage content individuly */	
		else if($action=='approve_res'){			
			$type=$this->input->get('type',TRUE);
			$id=$this->input->get('id',TRUE);
			
				$this->Resources_model->approveRes($type,$id,NULL);
				echo "approved";	
		}
		else if($action=='hide_res'){
			$type=$this->input->get('type',TRUE);
			$id=$this->input->get('id',TRUE);				
			$this->Resources_model->hideRes(true,$type,$id,NULL);
					
		}
		else if($action=='unhide_res'){
			$type=$this->input->get('type',TRUE);
			$id=$this->input->get('id',TRUE);				
			$this->Resources_model->hideRes(false,$type,$id,NULL);
					
		}
		else if($action=='del_res'){
			$type=$this->input->get('type',TRUE);
			$id=$this->input->get('id',TRUE);				
			$this->Resources_model->delRes($type,$id,NULL);			
			
		}
		else if($action=='man_multi_res'){
			
			$undelete=$this->input->post('undelete',TRUE);
			$delete=$this->input->post('delete',TRUE);
			$perm_delete=$this->input->post('perm_delete',TRUE);
			$approve=$this->input->post('approve',TRUE);
			$type=$this->input->post('type',TRUE);	
			/* get resource array*/
			if($type=='news')	
				$array=$this->input->post('news_id',TRUE);
			else if($type=='events')
				$array=$this->input->post('events_id',TRUE);
			else if($type=='articles')
				$array=$this->input->post('articles_id',TRUE);
			else if($type=='model_groups')
				$array=$this->input->post('groups_id',TRUE);
			else if($type=='device_models')
				$array=$this->input->post('models_id',TRUE);
			else if($type=='tools')
				$array=$this->input->post('tools_id',TRUE);
			/* content management action */	
			if($delete!=NULL)
				$this->Resources_model->hideRes(true,$type,NULL,$array);
			else if($undelete!=NULL)
				$this->Resources_model->hideRes(false,$type,NULL,$array);
			else if($perm_delete!=NULL)
				$this->Resources_model->delRes($type,NULL,$array);
			else if($approve!=NULL)
				$this->Resources_model->approveRes($type,NULL,$array);
				
			redirect('cms/resources/', 'refresh'); 					
		}
		
		else if($action == 'news'){
			$id=$this->input->get('id',TRUE);
			$data = array('display_list' => false,
			'userInfo' => $this->Account_model->isLogin(),
			'news_details' => $this->Resources_model->get_news_details($id), 
			'news_status'=>$this->Resources_model->check_inapproavl_news($id));
						
			 $this->load->view('cms/resources/news', $data);
		}
				
	}	
	public function activities($action=NULL){
		if (!$this->Account_model->isAuth()) return;
		if($this->Account_model->isLogin()->email!='model@i-mos.org') show_404();
		
		if($action==NULL){
			$data = array(
			'activities' => $this->Resources_model->get_activities_adv('all')
			);
			$this->load->view('cms/activities',$data);	
		}
		else if($action=='hide_res'){
			$type=$this->input->get('type',TRUE);
			$id=$this->input->get('id',TRUE);			
			$this->Resources_model->hideRes(true,$type,$id,NULL);
					
		}
		else if($action=='unhide_res'){
			$type=$this->input->get('type',TRUE);
			$id=$this->input->get('id',TRUE);				
			$this->Resources_model->hideRes(false,$type,$id,NULL);
					
		}
		else if($action=='del_res'){
			$type=$this->input->get('type',TRUE);
			$id=$this->input->get('id',TRUE);				
			$this->Resources_model->delRes($type,$id,NULL);			
			
		}			
		
	}
	public function users($action=NULL){
		if (!$this->Account_model->isAuth()) return;
		if($this->Account_model->isLogin()->email!='model@i-mos.org') show_404();
		
		if($action==NULL){
			$data = array(
			'allUserInfo' => $this->Account_model->getAllUsrInfo()
			);
			$this->load->view('cms/users',$data);	
		}
		else if($action=='hide_res'){
			$type=$this->input->get('type',TRUE);
			$id=$this->input->get('id',TRUE);			
			$this->Account_model->hideRes(true,$type,$id,NULL);
					
		}
		else if($action=='unhide_res'){
			$type=$this->input->get('type',TRUE);
			$id=$this->input->get('id',TRUE);				
			$this->Account_model->hideRes(false,$type,$id,NULL);
					
		}
		else if($action=='del_res'){
			$type=$this->input->get('type',TRUE);
			$id=$this->input->get('id',TRUE);				
			$this->Account_model->delRes($type,$id,NULL);			
			
		}		
	}
	public function user_experience(){
		if (!$this->Account_model->isAuth()) return;
		if($this->Account_model->isLogin()->email!='model@i-mos.org') show_404();
		$data = array(
			'user_experience' => $this->Resources_model->get_all_user_experience()
		);
		$this->load->view('cms/user_experience',$data);				
		
	}
	public function info_update(){
		$id=$this->input->get('id',TRUE);
		$data = array(
			'usr_info' => $this->Account_model->getUserInfoById($id)
		);	
		$this->load->view('cms/info_update',$data);					
	}
	public function info_update_submit(){
		$data = $_POST;
		$id=$this->input->post('id',TRUE);
		$this->Account_model->updateAcc($data);	
		redirect('cms/users/', 'refresh'); 	
	}

	public function model($action=NULL){
		if (!$this->Account_model->isAuth()) return;
		if($this->Account_model->isLogin()->email!='model@i-mos.org') show_404();
		if($action == NULL){
		$data = array(	
			'models' => $this->modelsim_model->getModelsInfo(),
			'userInfo' => $this->Account_model->isLogin()
			
		);	
		$this->load->view('cms/model/index.php',$data);	
		}
		else if($action=='edit_model'){	
			$id=$this->input->get('id',TRUE);
		
			$data = array(	
				'models' => $this->modelsim_model->getModelInfoById2($id)		
			);				
			$this->load->view('cms/model/edit_model.php',$data);	
			
		}
		else if($action=='edit_model_submit'){
			$model_id=$this->input->get_post('model_id', TRUE);
			$data = array(	
				'name' => $this->input->get_post('name', TRUE),
				'short_name' => $this->input->get_post('short_name', TRUE),
				'icon_name' => $this->input->get_post('icon_name', TRUE),
				'desc_name' => $this->input->get_post('desc_name', TRUE),
				'organization' => $this->input->get_post('organization', TRUE),
				'type' => $this->input->get_post('type', TRUE) 
					
			);						
			
			
			$this->modelsim_model->updatetModelInfo($data,$model_id);		
			redirect(base_url('/cms/model'), 'refresh');
		}
		else if($action=='del_res'){
			$type=$this->input->get('type',TRUE);
			$id=$this->input->get('id',TRUE);	
			$this->modelsim_model->delRes($type,$id,NULL);			
			
		}
	}

	/*
	 * Nodes management
	 *
	 */
	public function nodes($action = null) {
		if (!$this->Account_model->isAuth()) return;
		if($this->Account_model->isLogin()->email!='model@i-mos.org') show_404();

		if($action == null) {
			$data["nodes"] = $this->server_model->loadnodes();
			$this->load->view('cms/nodes', $data);
		}
		else if($action == "edit") {
			if($this->input->post("edit")) {
				$id = $this->input->post("id");
				$nodename = $this->input->post("nodename");
				$hostname = $this->input->post("hostname");
				$path = $this->input->post("path");
				$this->server_model->updatenode($id, $nodename, $hostname, $path);
				header("location: " . base_url("/cms/nodes/"));
				exit;
			}
			else
				$name = $this->input->get("name");
			$data = array("edit" => true, "node" => $this->server_model->selectnode($name));
			$this->load->view('cms/nodes_edit', $data);
		}
		else if($action == "add") {
			if($this->input->post("add")) {
				$nodename = $this->input->post("nodename");
				$hostname = $this->input->post("hostname");
				$path = $this->input->post("path");

				if($nodename != "" && $hostname != "" && $path != "") {
					$this->server_model->addnode($nodename, $hostname, $path);
					header("location: " . base_url("/cms/nodes/"));
					exit;
				}
			}
			$data = array("add" => true);
			$this->load->view('cms/nodes_edit', $data);
		}
		else if($action == "delete") {
			$name = $this->input->get("name");
			$this->server_model->deletenode($name);
			header("location: " . base_url("/cms/nodes/"));
			exit;
		}
	}

	/*
	 * CMS Page to list all the computer nodes
	 *
	 */
	public function monitor() {
		if (!$this->Account_model->isAuth()) return;
		if($this->Account_model->isLogin()->email!='model@i-mos.org') show_404();

		$this->load->view('cms/node_monitor');
	}

	/*
	 * Ajax Request to load all the status of computer nodes
	 *
	 */
	public function loadStatus() {
		if (!$this->Account_model->isAuth()) return;
		if($this->Account_model->isLogin()->email!='model@i-mos.org') show_404();

		$nodes = $this->server_model->loadnodes();

		$status = array();
		foreach($nodes as $node) {
			$status[$node->nodename]["hostname"] = $node->hostname;
			$status[$node->nodename]["mysqld"] = false;
			$status[$node->nodename]["httpd"] = false;
			$status[$node->nodename]["ngspice"] = array();

			/* CHECKING SERVER CONNECTIVITY */
			exec("ping " . $node->hostname . " -c 1 -w 1", $result);
			if(stripos($result[count($result) - 2], "0% packet loss") === false) {
				$status[$node->nodename]["ping"] = false;
				continue;
			}
			else
				$status[$node->nodename]["ping"] = true;

			/* GET INFORMATION FROM NODE */
			$root = "http://" . $node->hostname . $node->path . "/cms/execute/";
			$content = $this->server_model->remotelogin($node, array(
				$root . "ps",
				$root . "apache"
			));

			if($content) {
				/* CHECK APACHE */
				$ps = json_decode($content[0]);
				$httpd = $content[1];
				if(isset($ps))
					foreach($ps as $p) {
						if(preg_match("/mysqld/", $p))
							$status[$node->nodename]["mysqld"] = true;
						if(preg_match("/httpd/", $p) && preg_match("/" . $httpd . "/", $p))
							$status[$node->nodename]["httpd"] = true;
						if(preg_match("/ngspice/", $p)) {
							$parts = preg_split('/\s+/', $p);
							$status[$node->nodename]["ngspice"][] = array(
								"pid" => $parts[1],
								"time" => $parts[9]);
						}

					}
			}
		}
		echo json_encode($status);
	}

	/*
	 * Ajax request to execute command
	 */
	public function preexecute($action) {
		if (!$this->Account_model->isAuth()) return;
		if($this->Account_model->isLogin()->email!='model@i-mos.org') show_404();

		$node = $this->input->post("node");
		if($node)
			$node = $this->server_model->selectnode($node);
		
		if(!$node) {
			$this->output->set_status_header('405');
			return;
		}
		switch($action) {
			case "cleartemp":
				$content = $this->server_model->remotelogin($node, array(
						"http://" . $node->hostname . $node->path . "/cms/execute/cleartemp"
					)
				);
				echo json_encode($content[0]);
				break;
			case "terminatengspice":
				$pid = $this->input->post("pid");
				$content = $this->server_model->remotelogin($node, array(
						"http://" . $node->hostname . $node->path . "/cms/execute/terminatengspice?pid=" . $pid
					)
				);
				echo json_encode($content[0]);
				break;

		}
	}



	public function execute($action) {
		if (!$this->Account_model->isAuth()) return;
		if($this->Account_model->isLogin()->email!='model@i-mos.org') show_404();

		switch($action) {
			case "ps":
				$this->server_model->checkps();
				break;
			case "apache":
				$this->server_model->checkapache();
				break;
			case "cleartemp":
				if($this->server_model->cleartemp())
					echo "DELETE";
				else
					echo "FAIL";
				break;
			case "terminatengspice":
				$pid = $this->input->get("pid");
				if($this->server_model->terminatengspice($pid))
					echo "KILL";
				else
					echo "FAIL";
				break;
			default:
				break;
		}

	}
	
}