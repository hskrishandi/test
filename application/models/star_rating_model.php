<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Star_rating_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	/*
		function islogin()
		Check the user login or not
		Return value:
		false: no login status
		Object: user information
	*/

	public function rate($acc, $model_id, $val){
		if ($this->isUsrRated($acc->id, $model_id)){
			//Update the database
			$data = array(
               'rate' => $val
            );
			$this->db->where('user_id', $acc->id)->where('model_id', $model_id);
			$this->db->update('starrating', $data); 
		} else {
			//insert to datebase
			$data = array(
               'user_id' => $acc->id,
               'model_id' => $model_id,
               'rate' => $val
            );

			$this->db->insert('starrating', $data); 
		}
	}

	public function readAvgRate($id){
		$this->db->select_avg('rate')->from('starrating')->where('model_id', $id);
		$query = $this->db->get();
		$row = $query->row();
		return $row->rate;
	}

	public function readUsrRate($id){
		$this->db->select('rate')->from('starrating')->where('model_id', $id)->where('user_id', $user_id);
		$query = $this->db->get();
		$row = $query->row();
		return $row->rate;
	}
	public function isUsrRated($user_id, $model_id){
		$this->db->select()->where('model_id', $model_id)->where('user_id', $user_id);
		$query = $this->db->get('starrating');
		if ($query->num_rows() > 0){
			return true;
		} else {
			return false;
		}
	}
	
	
	
}

?>
