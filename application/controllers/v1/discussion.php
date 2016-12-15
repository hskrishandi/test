<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Discussion extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->library('user_agent');
		$this->load->helper('template_inheritance');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->model('Account_model');
		$this->load->model('discussion_model');
	}	
	
	

	public function index ()
	{
		$data = array(	
			'posts' => $this->discussion_model->getPosts('undelete',NULL),
			'userInfo' => $this->Account_model->isLogin(),
			'activeUser' => $this->discussion_model->getActiveUser(),
			'mostComment' => $this->discussion_model->getMostCommentUser(),
			'countComment' => $this->discussion_model->getcountComment()
		);

		$this->load->view('discussion/index',$data);
	}

	public function blog($userid=0)
	{		
		if($userid==0){
			if (!$this->Account_model->isAuth()) return;
			else
			redirect('/discussion/blog/'.$this->Account_model->isLogin()->id, 'refresh'); 
		}
		
		else if($userid>0){
			
			$data = array(
				'blogOwnerid' => $userid,
				'displayname' => $this->discussion_model->getUserName($userid),
				'posts' => $this->discussion_model->getUserPosts($userid),
				'userInfo' => $this->Account_model->isLogin(),
				'countComment' => $this->discussion_model->getcountComment()	
			);
		}
		else{			
			show_404();			
		}
		$this->load->view('discussion/blog',$data);
	}

	public function posting()
	{
		if (!$this->Account_model->isAuth()) return;
		$data = array(	
				'userInfo' => $this->Account_model->isLogin()
		);	
		
		$this->load->view('discussion/posting',$data);
		
	}



	public function submitPostForm()
	{
			if (!$this->Account_model->isAuth()) return;
		
			if($_POST['userid']!=NULL){
				
							$data = array(	
				'userInfo' => $this->Account_model->isLogin(),
				'success'=>$this->discussion_model->createPost($_POST['subject'],nl2br($_POST['editor1']),$_POST['datetime'],$_POST['userid'])	
		);

			 redirect('/discussion/index', 'refresh'); 
		
			
		}
		
	}
	
	public function submitReplyForm($type=NULL) 
	{
		if (!$this->Account_model->isAuth()) return;
		
		if($_POST['userid'] != NULL) {
			if(isset($_POST['receiver'])){
				$this->discussion_model->sendEmail($_POST['first_name'],$_POST['last_name'],$_POST['receiver'],$_POST['postid']);
			}
			$data = array(	
				'userInfo' => $this->Account_model->isLogin(),
				'success' => $this->discussion_model->replyPost($_POST['postid'],nl2br($_POST['comment']),$_POST['datetime'],$_POST['userid'],$type)
			);
			

			if ($this->agent->is_referral()) {
				redirect($this->agent->referrer(), 'refresh'); 
			} else {
				redirect('/discussion/postDetails?postid='.$_POST['postid'], 'refresh'); 
			}			
		}		
	}
	
	
	public function postDetails()
	{
		
		if($_GET['postid']!=NULL){
			
			$postid=$_GET['postid'];
			$data = array(	
		
			'posts' => $this->discussion_model->getPosts('all',$postid),
			'reply' => $this->discussion_model->getReply($postid),
			'countComment' => $this->discussion_model->getCountCommentById($postid),
			'userInfo' => $this->Account_model->isLogin()
	
			);
			
			$this->load->view('discussion/postDetails',$data);
		}
				
	}
	

	public function test()
	{		
		$this->load->view('discussion/test');
	}



	public function comment($postid)
	{
			$data = array(	
		
			'posts' => $this->discussion_model->getPosts('all',$postid),
			'reply' => $this->discussion_model->getReply($postid),
			'countComment' => $this->discussion_model->getCountCommentById($postid),
			'userInfo' => $this->Account_model->isLogin()
	
			);
			
			$this->load->view('discussion/comment',$data);
	}
	
	public function maintain(){
		if(isset($_GET['action'])&&isset($_GET['postid'])&&!isset($_GET['commentid'])){
			$postid=$_GET['postid'];
			$action=$_GET['action'];
			$pre_page=$_GET['pre'];

			
			if($action=='del'){
				$userid=$this->Account_model->isLogin()->id;
				
				$this->discussion_model->delPost($postid);
				if($pre_page=='blog'){
					$blogid=$_GET['blogid'];
					redirect('/discussion/blog/'.$blogid, 'refresh');
				}
				else
					redirect('/discussion/', 'refresh');
			}	
			
			if($action=='edit'){
			$data = array(
				'subject' => $this->input->get_post('subject', TRUE),
				'content' => $this->input->get_post('editor1', TRUE)
			);				
				
				$this->discussion_model->edit_post($data,$postid);
				redirect('/discussion/postDetails?postid='.$postid, 'refresh');
			}
		}
		if(isset($_GET['action'])&&isset($_GET['commentid'])){
			$commentid=$_GET['commentid'];
			$action=$_GET['action'];
			$postid=$_GET['postid'];
			if($action=='del'){
				$this->discussion_model->delComment($commentid);
				redirect('discussion/postDetails?postid='.$postid, 'refresh');				
			}
		}
		
	}
	public function edit_post($postid){
		if (!$this->Account_model->isAuth()) return;
		$data = array(	
				'userInfo' => $this->Account_model->isLogin(),
				'posts' => $this->discussion_model->getPosts('all',$postid) 
				
		);	
		
		$this->load->view('discussion/edit_post',$data);
		
	}
	
}

?>
