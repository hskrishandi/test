<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Developer_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

		
	public function getFormData($user_id)
	{
		$this->db->select('title,authorList')->from('developer_form')
		->where(array("user_id" => $user_id));
		
		$query = $this->db->get();
		if ($query->num_rows() == 1) {
			$result = $query->row(0);
			return $result;
		}
		
		return null;
	}
	
}

?>
