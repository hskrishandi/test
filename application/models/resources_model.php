<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Resources_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	/**
	 * Get brief info of recent activities, sorted by date
	 */
	public function get_activities_adv($show, $limit = NULL, $offset = 0)
	{
		
		if($show=='all')
			$this->db->select('id, UNIX_TIMESTAMP(date) as date, content, del_status')->from('activities')->order_by("date desc");
		else{
			if($show=='delete')
				$del_status=1;
			else if($show=='undelete')
				$del_status=0;
			
			if($limit == NULL)
				$this->db->select('id, UNIX_TIMESTAMP(date) as date, content, del_status')->from('activities')->where(array("approval_status"=> 1,"del_status"=>$del_status))->order_by("date desc");
			else
				$this->db->select('id, UNIX_TIMESTAMP(date) as date, content, del_status')->from('activities')->where(array("approval_status"=> 1,"del_status"=>$del_status))->order_by("date desc")->limit($limit, $offset);
		}		

		return $this->db->get()->result();
	}	

	/**
	 * Get recent events, sorted by date
	 */	
	 
	public function get_events_adv($show, $past = false, $limit = NULL, $offset = 0)
	{
		if($show=='all'){
			$this->db->from('events')->order_by("start_date " . ($past ? 'desc' : 'asc'))->where('end_date ' . ($past ? '<' : '>=') . ' CURDATE()')->limit($limit, $offset);					
		}
		else{
			if($show=='delete')
				$del_status=1;
			else if($show=='undelete')
				$del_status=0;
			
			if($limit == NULL){
				$this->db->from('events')->where(array("approval_status"=> 1,"del_status"=>$del_status))->order_by("start_date " . ($past ? 'desc' : 'asc'))->where('end_date ' . ($past ? '<' : '>=') . ' CURDATE()');							
			}	
			else{
				$this->db->from('events')->where(array("approval_status"=> 1,"del_status"=>$del_status))->order_by("start_date " . ($past ? 'desc' : 'asc'))->where('end_date ' . ($past ? '<' : '>=') . ' CURDATE()')->limit($limit, $offset);			
			}
		}		
		return $this->db->get()->result();
	}	 
	/*
	public function get_events($past = false, $limit = 20, $offset = 0)
	{
		$this->db->from('events')->where("approval_status", 1)->order_by("start_date " . ($past ? 'desc' : 'asc'))->where('end_date ' . ($past ? '<' : '>=') . ' CURDATE()')->limit($limit, $offset);
		return $this->db->get()->result();
	}
	*/
	public function edit_event($data,$event_id){
		
		$this->db->update('events',$data,array('id' => $event_id));

	}
	
	public function get_event_by_id($event_id){
		$this->db->from('events')->where("id",$event_id);
		return $this->db->get()->result();		
	}
	public function approve_event($event_id){
		$this->db->query("UPDATE `events` SET  `approval_status` =  '1' WHERE  `events`.`id` ='$event_id'");
		
	}

	/**
	 * Get articles of type $type(journals/books), sorted by name
	 */	
	 
	public function get_articles_adv($show, $type, $limit = NULL, $offset = 0){
		
		if($show=='all'){
			$this->db->from('articles')->order_by("year desc")->order_by("id desc");
		}else{
			if($show=='delete')
				$del_status=1;
			else if($show=='undelete')
				$del_status=0;
			
			if($limit == NULL){
				$this->db->from('articles')->where(array("approval_status"=> 1,"del_status"=>$del_status))->order_by("year desc")->order_by("id desc");							
			}	
			else{
				$this->db->from('articles')->where(array("approval_status"=> 1,"del_status"=>$del_status))->order_by("year desc")->order_by("id desc")->limit($limit, $offset);							
			}
		}			
		return $this->db->get()->result();
	}
	 

		
	public function get_articles_details($id){
		if($id!=NULL){
			$query = $this->db->query("SELECT * FROM articles WHERE id='$id'");
		return $query->result();		
		}
	}
	public function edit_article($data,$article_id){
		
		$this->db->update('articles',$data,array('id' => $article_id));

	}

	public function del_article($article_id){
		$this->db->query("DELETE FROM articles WHERE id='$article_id'");
		
	}	
	public function approve_article($article_id){
		$this->db->query("UPDATE `articles` SET  `approval_status` =  '1' WHERE  `articles`.`id` ='$article_id'");
		
	}
	/**
	 * Get model groups, sorted by name
	 */	
	public function get_groups_adv($show, $limit = NULL, $offset = 0)
	{
		
		if($show=='all'){
			$this->db->from('model_groups')->order_by("name asc");			
		}
		else{
			if($show=='delete')
				$del_status=1;
			else if($show=='undelete')
				$del_status=0;
			
			if($limit == NULL)
				$this->db->from('model_groups')->where(array("approval_status"=> 1,"del_status"=>$del_status))->order_by("name asc");
			else
				$this->db->from('model_groups')->where(array("approval_status"=> 1,"del_status"=>$del_status))->order_by("name asc")->limit($limit, $offset);
		}		
		
		
		return $this->db->get()->result();
	}
	
	
	public function get_groups_details($group_id)
	{
		$this->db->from('model_groups')->where("id", $group_id);
		return $this->db->get()->result();
	}


	public function edit_group($data,$group_id){
		
		$this->db->update('model_groups',$data,array('id' => $group_id));
	}
	
	public function del_group($group_id){
		$this->db->query("DELETE FROM model_groups WHERE id='$group_id'");
		
	}	
	
	public function approve_group($group_id){
		$this->db->query("UPDATE `model_groups` SET  `approval_status` =  '1' WHERE  `model_groups`.`id` ='$group_id'");
		
	}
	public function get_models_adv($show, $status = NULL, $limit = NULL, $offset = 0)
	{
		
		if($show=='all')
			$this->db->from('device_models')->order_by("name asc");
		else{
			if($show=='delete')
				$del_status=1;
			else if($show=='undelete')
				$del_status=0;
			
			if($limit == NULL)
				$this->db->from('device_models')->order_by("name asc")->where(array("approval_status" => 1, 'status' => $status, "del_status"=>$del_status));
			else
				$this->db->from('device_models')->order_by("name asc")->where(array("approval_status" => 1, 'status' => $status, "del_status"=>$del_status))->limit($limit, $offset);	
		}		
		
		
		
		return $this->db->get()->result();
	}
		
	/**
	 * Get device models (released/developing), sorted by name
	 */	
	public function get_models($status, $limit = 20, $offset = 0)
	{
		$this->db->from('device_models')->order_by("name asc")->where(array("approval_status" => 1, 'status' => $status))->limit($limit, $offset);
		return $this->db->get()->result();
	}
	

	public function get_models_by_id($model_id)
	{
		$this->db->from('device_models')->order_by("name asc")->where(array("id" => $model_id));
		return $this->db->get()->result();
	}
	public function approve_model($model_id){
		$this->db->query("UPDATE `device_models` SET  `approval_status` =  '1' WHERE  `device_models`.`id` ='$model_id'");
		
	}
	public function edit_model($data,$modele_id){
		$this->db->update('device_models',$data,array('id' => $modele_id));		
	}	
	public function del_model($model_id){
		$this->db->query("DELETE FROM device_models WHERE id='$model_id'");	
		
	}	
	/**
	 * Get brief info of news, sorted by date
	 */ 
	/*
	public function get_news($limit = 5, $offset = 0)
	{
		$this->db->select('id, UNIX_TIMESTAMP(post_date) as post_date, title, approval_status')->from('news')->where("approval_status", 1)->order_by("post_date desc")->limit($limit, $offset);
		return $this->db->get()->result();
	}	
	*/
	public function get_news_details($id){
		if($id!=NULL){
			$query = $this->db->query("SELECT id, UNIX_TIMESTAMP(post_date) as post_date, title, content,approval_status FROM news WHERE id='$id'");
			
		return $query->result();
		}
	}
	
	public function get_news_adv($show, $limit = NULL, $offset = 0)
	{	
		/* show all posts which del_status=0 or del_status=1 */
		if($show=='all')
			$this->db->select('id, UNIX_TIMESTAMP(post_date) as post_date, title,approval_status, del_status')->from('news')->order_by("post_date desc");
		/* show all post according to $del_status */
		else{
			if($show=='delete')
				$del_status=1;
			else if($show=='undelete')
				$del_status=0;
			
			if($limit == NULL)
			$this->db->select('id, UNIX_TIMESTAMP(post_date) as post_date, title,approval_status, del_status')->from('news')->where(array("approval_status"=> 1,"del_status"=>$del_status))->order_by("post_date desc");
			else
				$this->db->select('id, UNIX_TIMESTAMP(post_date) as post_date, title, approval_status, del_status')->from('news')->where(array("approval_status"=> 1,"del_status"=>$del_status))->order_by("post_date desc")->limit($limit, $offset);	
		}
		
		return $this->db->get()->result();
	}	
	
	
	public function get_inapproavl_news()
	{
		$this->db->select('id, UNIX_TIMESTAMP(post_date) as post_date, title')->from('news')->where("approval_status", 0)->order_by("post_date desc");
		return $this->db->get()->result();
	}	
	public function check_inapproavl_news($news_id)
	{
		$this->db->select('id, UNIX_TIMESTAMP(post_date) as post_date, title')->from('news')->where(array("approval_status"=> 0,"id"=>$news_id))->order_by("post_date desc");
		return $this->db->get()->result();
	}

	
	public function approve_news($news_id){
		$this->db->query("UPDATE `news` SET  `approval_status` =  '1' WHERE  `news`.`id` ='$news_id'");
		
	}
	
	public function edit_news($news_id,$title,$content){
		$this->db->query("UPDATE `news` SET  `title` =  '$title',
`content` =  '$content' WHERE  `news`.`id`='$news_id'");
		
	}


	/**
	 * Get tools, sorted by name
	 * $param string $type type of model(device simulators, circuit simulators, model parameter extractors or model interface)
	 */	
	public function get_tools_adv($show, $type, $limit = NULL, $offset = 0)
	{		

		if($show=='all'){
		$this->db->from('tools')->order_by("name asc");		
		}
		else{
			if($show=='delete')
				$del_status=1;
			else if($show=='undelete')
				$del_status=0;
			
			if($limit == NULL)
				$this->db->from('tools')->where(array("approval_status"=> 1,"del_status"=>$del_status))->order_by("name asc");
			else
				$this->db->from('tools')->where(array("approval_status"=> 1,"del_status"=>$del_status))->order_by("name asc")->limit($limit, $offset);
		}
		
		if ($type && strtolower($type) != 'all') {
			$this->db->where('type', $type);		
		}	
		return $this->db->get()->result();
	}
	


	public function get_tools_by_id($tool_id)
	{		
		$this->db->from('tools')->where("id",$tool_id);

		return $this->db->get()->result();
	}
	public function approve_tool($tool_id){
		$this->db->query("UPDATE `tools` SET  `approval_status` =  '1' WHERE  `tools`.`id` ='$tool_id'");
		
	}
	public function del_tool($tool_id){
		$this->db->delete('tools',array('id' => $tool_id));	
		
	}	
	public function edit_tool($data,$tool_id){
		
		$this->db->update('tools',$data,array('id' => $tool_id));

	}
	/**
	 * Get approved user experience
	 */	
	public function get_user_experience($limit = 2, $offset = 0)
	{
		$this->db->select("ue.comment, ue.date, u.first_name, u.last_name, u.organization")->from('user_experience ue')->join('users u', 'u.id = ue.user_id', 'inner')
				 ->where("ue.approval_status", 1)->order_by("ue.date desc")->limit($limit, $offset);
		return $this->db->get()->result();
	}
	
	public function get_all_user_experience(){
		$this->db->select("ue.id, ue.comment, ue.date, ue.approval_status, u.first_name, u.last_name, u.organization")->from('user_experience ue')->join('users u', 'u.id = ue.user_id', 'inner')->order_by("ue.date desc");
		return $this->db->get()->result();
		
	}

	/**
	 * Add a user experience record for pending
	 */	
	public function add_user_experience($user_id, $comment)
	{
		$data = array(
		   'comment' => $comment,
		   'user_id' => $user_id
		);

		$this->db->insert('user_experience', $data); 
	}
	
	public function insertNews($data){
		$this->db->insert('news', $data); 
	}
	
	public function insertEvents($data){
		$this->db->insert('events', $data); 	
	}
	
	public function insertArticles($data){
		$this->db->insert('articles', $data); 	
	}
	
	public function insertGroups($data){
		$this->db->insert('model_groups', $data); 
	}
	
	public function insertModels($data){
		$this->db->insert('device_models', $data); 
	}
	
	public function insertTools($data){
		$this->db->insert('tools', $data); 
	}	
	
	public function hideRes($hidden,$type,$id,$array){
		/*multiple hiding*/
		if($hidden==true)
			$del_status = 1;
		else if($hidden==false)
			$del_status = 0; 	
		
		if($array!=NULL){
			for($i=0; $i<count($array);$i++){
				$id=$array[$i];
				$this->db->query("UPDATE $type SET del_status =  '$del_status' WHERE id = '$id'");
			}
		}
		else{
			$this->db->query("UPDATE $type SET  del_status =  '$del_status' WHERE id = '$id'");
		}
	}
	public function delRes($type,$id,$array){
		/*multiple del*/
		if($array!=NULL){
			for($i=0; $i<count($array);$i++){
				$id=$array[$i];
				$this->db->query("DELETE FROM $type WHERE  id = '$id'");
			}		
		}
		else{
			$this->db->query("DELETE FROM $type WHERE id = '$id'");	
		}
	}
	public function approveRes($type,$id,$array){
		/*multiple approve*/
		if($array!=NULL){
			for($i=0; $i<count($array);$i++){
				$id=$array[$i];
				$this->db->query("UPDATE $type SET approval_status =  '1' WHERE  id ='$id'");
			}		
		}
		else{
			$this->db->query("UPDATE $type SET approval_status =  '1' WHERE  id ='$id'");	
		}
	}
	
	
	public function countDisapporvedRes(){
		$query = $this->db->query('SELECT * FROM news where approval_status=0');
		$query2 = $this->db->query('SELECT * FROM model_groups where approval_status=0');
		$query3 = $this->db->query('SELECT * FROM tools where approval_status=0');
		$query4 = $this->db->query('SELECT * FROM device_models where approval_status=0');
		$query5 = $this->db->query('SELECT * FROM articles where approval_status=0');
		$query6 = $this->db->query('SELECT * FROM events where approval_status=0');
		return $query->num_rows()+$query2->num_rows()+$query3->num_rows()+$query4->num_rows()+$query5->num_rows()+$query6->num_rows();				
	}
}

?>
