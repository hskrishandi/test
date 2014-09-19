<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Developer_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

		
	public function getModelsInProgress()
	{
		$this->db->select('user_name,stage,model_name,description')->from('models_in_progress')->where(array('released' => '0','complete' => '1'))
		->order_by('stage', 'desc');//->limit(5);
		
		$query = $this->db->get();
		
		return $query->result();
	}
	
	public function getUserModelList($USER_ID)
	{
		$this->db->select('id,model_name,last_update_time,complete')->from('models_in_progress')->where(array("user_id" => $USER_ID))->order_by('complete', 'asc');//->limit(5);
		$query = $this->db->get();
		$ret = array('incomplete' => array(), 'complete' => array());
		$result = $query->result();
		
		foreach ($result as $elem) {
			if ($elem->complete == 1) {
				$ret['complete'][] = $elem;
			} else {
				$ret['incomplete'][] = $elem;
			}
		}
		return $ret;
	}
	
	public function checkModelExistence($data)
	{
		$this->db->select('model_name')->from('models_in_progress')->where(array("user_id" => $data['user_id'],"id" => $data['id']));
		$query = $this->db->get();
		$result = $query->result();
		if(sizeof($result))
			return true;
		else return false;
	}
	
	public function deleteModel($data)
	{
		$this->db->delete('models_in_progress',array('id' => $data['id']));
	}
	
	public function addNewModelToDb($data)
	{
		if(isset($data)){
		$this->db->insert('models_in_progress',$data);
		}
	}
	
	public function updateModelInfo($data)
	{
		if(isset($data)){
			$this->db->where('id', $data['id']);
			$this->db->update('models_in_progress', $data);
		}
	}
	
	public function getNextModelID()
	{
		$this->db->select('id')->from('models_in_progress')
		->order_by('id', 'desc')->limit(1);
		$query = $this->db->get();
		return $query->result();
	}
	
}

?>
