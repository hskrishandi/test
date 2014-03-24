<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Developer_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

		
	public function getModelsInProgress()
	{
		$this->db->select('user_name,stage,model_name,description')->from('models_in_progress')
		->order_by('stage', 'desc');//->limit(5);
		
		$query = $this->db->get();
		
		return $query->result();
	}
	
	public function addNewModelToDb($data)
	{
		$this->db->insert('models_in_progress',$data);
	}
	
}

?>
