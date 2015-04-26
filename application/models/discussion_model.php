<?php

class Discussion_model extends CI_Model {

	public function __construct()
	{	
		$this->load->library('email');
		$this->load->database();
		
	}
	
	public function getPosts($show,$postid){
		
		if($postid==NULL){
			if($show=='all')
				$query = $this->db->query("SELECT * 
			FROM users, discussion
			WHERE users.id = discussion.userid 
			ORDER BY postid DESC");
			else{
				if($show=='delete')
					$del_status=1;
				else if($show=='undelete')
					$del_status=0;
				
				$query = $this->db->query("SELECT * 
			FROM users, discussion
			WHERE users.id = discussion.userid AND del_status = '$del_status'
			ORDER BY postid DESC");
	
			}	
		}
		else if($postid!=NULL){
			$query = $this->db->query("SELECT * FROM discussion as d, users as u WHERE u.id=d.userid AND postid= '$postid' ORDER BY postid DESC");
				
				
			}
		return $query->result();
	}



	

	public function getUserPosts($userid){
		if($userid!=NULL){
			$query = $this->db->query("SELECT * FROM discussion as d, users as u WHERE u.id=d.userid AND userid='$userid' ORDER BY postid DESC");
				
			return $query->result();
			
		}
		
	}
	public function getUserName($userid){
		if($userid!=NULL){
			$query = $this->db->query("SELECT displayname FROM  users WHERE id='$userid' ");
				
			return $query->row();
			
		}
		
	}
	
	public function createPost($subject,$content,$datetime,$userid){
		$content = addslashes($content);
		$sql="INSERT INTO `discussion` VALUES (NULL,'$subject','$content','$datetime','$userid',0)";
		mysql_query($sql) or die(mysql_error()); 
		return true;

			
	}
	
	public function replyPost($postid,$comment,$datetime,$userid,$type){
		$comment=addslashes($comment);
		$sql="INSERT INTO `post_comments` VALUES (NULL,'$postid','$comment','$datetime','$userid','$type')";
		mysql_query($sql) or die(mysql_error()); 
		return true;		
	}
	
	public function getReply($postid){
		if($postid!=NULL){
			$query = $this->db->query("SELECT *,p.datetime FROM post_comments as p, discussion as d, users as u WHERE p.postid=d.postid AND d.postid='$postid' AND p.userid=u.id ORDER BY commentid DESC");
			return $query->result();
			
		}
		
	}
	public function getCommentId($postid){
		if($postid!=NULL){
			$query = $this->db->query("SELECT commentid FROM post_comments WHERE postid = '$postid'");
			$row = $query->row_array();
			return $row['commentid']; 	
		}
		
	}
	
	public function getCountComment(){
			
			
			$query = $this->db->query("SELECT COUNT( p.postid ) AS count , d.postid
FROM discussion AS d
LEFT JOIN post_comments AS p ON p.postid = d.postid
GROUP BY d.postid ORDER BY d.postid DESC");
			$array;
			$i=0;
			foreach($query->result() as $row):
				$array[$row->postid]=$row->count;
			endforeach;

			return $array;
	}	

	
	public function getCountCommentById($postid){
			$query = $this->db->query("SELECT count(*) as countComment from post_comments  WHERE postid='$postid'");
			return $query->row()->countComment;
	}
	
	public function getActiveUser(){
		$query = $this->db->query("SELECT COUNT( * ) AS count, u.displayname, u.id, u.photo_path, u.photo_ext
FROM users AS u, discussion AS d
WHERE u.id = d.userid
GROUP BY u.id
ORDER BY count DESC 
LIMIT 0 , 7 ");
			return $query->result();
		
	}
	
	public function getCountModelCommentById($post_id){
			$query = $this->db->query("SELECT count(*) as countComment from post_comments  WHERE postid='$post_id' AND type = 'model'");
			return $query->row()->countComment;
	}
	

	
	public function getMostCommentUser(){
		$query = $this->db->query("SELECT COUNT( * ) AS count, u.displayname, u.id,
u.photo_path, u.photo_ext
FROM users AS u, post_comments AS p
WHERE u.id = p.userid
GROUP BY u.id
ORDER BY count DESC 
LIMIT 0 , 7 ");
			return $query->result();		
	}	
	public function delPost($postid){
		$this->db->query("DELETE FROM post_comments WHERE postid='$postid'");
		$this->db->query("DELETE FROM discussion WHERE postid='$postid'");
		return true;

	}
	
	public function delComment($commentid){
		$this->db->query("DELETE FROM post_comments WHERE commentid='$commentid'");
		return true;
	}
	public function edit_post($data,$postid){
		$this->db->where('postid', $postid);
		$this->db->update('discussion', $data); 
		return true;
	}	
	
	public function getModelPic($postid){
		$query = $this->db->query("SELECT name FROM discussion AS d, model_info AS m WHERE postid=18 AND m.post_id = d.postid");
			return $query->result();		
		
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
				$this->db->query("UPDATE $type SET del_status =  '$del_status' WHERE postid = '$id'");
			}
		}
		else{
			$this->db->query("UPDATE $type SET  del_status =  '$del_status' WHERE postid = '$id'");
		}
	}
	public function delRes($type,$id,$array){
		/*multiple del*/
		$this->db->query("DELETE FROM post_comments WHERE postid='$id'");
		if($array!=NULL){
			for($i=0; $i<count($array);$i++){
				$id=$array[$i];
				$this->db->query("DELETE FROM $type WHERE  postid = '$id'");
			}		
		}
		else{
			$this->db->query("DELETE FROM $type WHERE postid= '$id'");	
		}
	}
	
		public function sendEmail($first_name,$last_name,$receiver,$postid){
		$post_link = base_url('discussion/postDetails?postid='.$postid);
		$config['mailtype']='html';
		$this->email->initialize($config);
		$this->email->from("info@i-mos.org", 'i-MOS');
		$this->email->to($receiver);
		$this->email->subject("[i-MOS]Notification of new comment");
		$msg='Dear Sir/Madam, <br /> <br />You have received a new comment from your post.<br /> '.$post_link.'<br /><br />Best Regards,<br />i-MOS Team';
		$this->email->message($msg);
		$this->email->send();			
		
		
	}
	
	
	
	
	}
	


?>
