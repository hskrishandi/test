<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		require_once dirname(__FILE__) . '/includes/bootstrap.inc';
		require_once dirname(__FILE__) . '/includes/password.inc';
		$this->load->database();
		$this->load->library('email');
		$this->load->driver('session');
		//$this->session->native->select_driver('native');
		//$this->load->library('session');
		$this->load->library('LoginPass');
		$this->load->helper('url');
	}
	/*
		function islogin()
		Check the user login or not
		Return value:
		false: no login status
		Object: user information
	*/

	public function login($email, $pwd){
		$query = $this->db->get_where("users", array('email'=>$email),1,0);
		if ($query->num_rows() > 0){
			$row = $query->first_row();
			if ($this->_isPassVaild($row->password, $pwd)){
				if ($row->isactivated=='1'){
					//$this->db->where('id',$row->id)->update('users', array("sessionid"=>$this->session->native->userdata['session_id']));
					$this->session->native->set_userdata(array('id'=>$row->id));
					return "ok";
				}else{
					return "noactive";
				}
                        }else{
				return "noaccpass";
			}
                } else{
			return "noaccpass";
		}
	}

	public function logout(){
	var_dump($this->session->native->all_userdata());
		$this->session->native->sess_destroy();
		var_dump($this->session->native->all_userdata());
	}
	public function isEmailDup($email){
		$this->db->select('id')->from('users')->where(array("email" => $email));
		$query = $this->db->get();
		$rowcount = $query->num_rows();
		if ($rowcount > 0)
			return true;
		else
			return false;
	}
	public function islogin(){
		$id = $this->session->native->userdata('id');
		if (isset($id)){
			$query = $this->db->get_where("users", array('id'=>$id),1,0);
			if ($query->num_rows > 0 ){
				$row = $query->first_row();
				return $row;
				/*
				if ($row->id == $this->session->native->userdata['id']){
					return $row;
				}else{
					return false;
				}
				*/
			}else{
				return false;
			}
		}else{
			return false;
		}
	}

	public function getUsrInfo($id){
		$query = $this->db->get_where("user", array('id'=>id),1,0);
		if ($query->num_rows > 0 ){
			$row = $query->first_row();
				return $row;
		}else{
			return false;
		};
	}
	
	public function getAllUsrInfo(){
		$this->db->from('users')->order_by('displayname');	
		return $this->db->get()->result();
	}

	public function _isPassVaild($db_pwd, $entered_pwd){

		//$account = new objpass;
		//$account->pass = $db_pwd;
		$objpass = new LoginPass;
		$objpass->pass = $db_pwd;
		return user_check_password($entered_pwd, $objpass);
	}

	public function createUser($data){
          unset($data['retypepassword']);
		$data['password'] = _password_crypt('sha512', $data['password'], _password_generate_salt(DRUPAL_HASH_COUNT));
		$this->db->insert('users', $data);
		$id = $this->db->insert_id();
		$uuid = uniqid();
		$this->db->insert('activation_page', array("page"=>$uuid, "id"=>$id));
		$config['mailtype']='html';
		$this->email->initialize($config);
		$this->email->from("info@i-mos.org", 'i-MOS');
		$this->email->to($data['email']);
		$this->email->subject("[i-MOS]Account Activation");
		$msg="Dear ". $data['last_name']. ' '. $data['first_name']. '<br /> <br />Thank you for registering with i-MOS. Please click the following link to activate your account:<br /> '. base_url('/account/activate/').'/'.$uuid.'<br /><br />Best Regards,<br />i-MOS Team';
		$this->email->message($msg);
		$this->email->send();
	}
	
	public function info_update($data){
		$this->db->where('id', $this->islogin()->id);	
		$this->db->update('users', $data); 
	}

	public function changePass($email, $oldpass, $newpass){
		$query = $this->db->get_where("users", array('email'=>$email),1,0);
		if ($query->num_rows() > 0){
			$row = $query->first_row();
			if ($this->_isPassVaild($row->password, $oldpass)){
				$data['password'] = _password_crypt('sha512', $newpass, _password_generate_salt(DRUPAL_HASH_COUNT));
				$this->db->where('id', $row->id);	
				$this->db->update('users', $data); 
				return true;
            }else{
				return false;
			}
        } else{
			return false;
		}
	}
	
	public function newPass($email){
		$query = $this->db->get_where("users", array('email'=>$email),1,0);
		$newpass = uniqid();
		if ($query->num_rows() > 0){
			$row = $query->first_row();
			$data['password'] = _password_crypt('sha512', $newpass, _password_generate_salt(DRUPAL_HASH_COUNT));
			$this->db->where('id', $row->id);	
			$this->db->update('users', $data);
			$config['mailtype']='html';
			$this->email->initialize($config);
			$this->email->from("info@i-mos.org", 'i-MOS');
			$this->email->to($email);
			$this->email->subject("[i-MOS]Request New Password");
			$data['email'] = $email;
			$data['password'] = $newpass;
			$data['userinfo'] = $row;
			$msg = $this->load->view('account/newPass_email_temple', $data, true);
			$this->email->message($msg);
			$this->email->send();
        }
	}
	public function activate($page){
		$query = $this->db->query("SELECT * FROM activation_page where page='".$page."';");
		$row = $query->result();
		if ($query->num_rows() > 0){

			$data = array('isactivated' => 1, 'sessionid'=>$this->session->native->userdata['session_id']);

			$where = "id = ".$row[0]->id;

			$str = $this->db->update_string('users', $data,$where);
			$this->db->query($str);

			$this->db->delete("activation_page", array("page" => $page));

			$this->session->native->set_userdata(array('id'=>$row[0]->id));

			return true;
		}else{
			return false;
		}
	}
	
	public function isAuth($userlevel=0){
		$info = $this->Account_model->islogin();
		if (uri_string() !=="account/authErr")
			$this->session->native->set_userdata('refer', uri_string());
		if ($info === false){
				redirect('/account/authErr');
		} else {
			if($info->class < $userlevel){
				redirect('account/authErr');
			} else {
				return true;
			}
		}
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
				$this->db->query("UPDATE $type SET status =  '$del_status' WHERE id = '$id'");
			}
		}
		else{
			$this->db->query("UPDATE $type SET  status =  '$del_status' WHERE id = '$id'");
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
	public function getUserInfoById($id){
		$this->db->from('users')->where("id", $id);
		return $this->db->get()->result();
	}
	
		
	public function updateAcc($data){
		extract($data);
		$this->db->query("UPDATE  `imos2`.`users` SET  
`first_name` =  '$first_name',
`last_name` =  '$last_name',
`organization` =  '$organization',
`displayname` =  '$displayname',
`address` =  '$address',
`position` =  '$position',
`tel` =  '$tel',
`fax` =  '$fax' WHERE  `users`.`id` ='$id'");	
	}
	
	
}

?>
