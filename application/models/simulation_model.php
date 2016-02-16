<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Simulation_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->config->load('simulation');
	}
	
	public function getModelCount()
	{
		$this->db->select('COUNT(id) as count')->from('model_info');
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			$result = $query->row();
			return $result->count;
		}
	
		return 0;
	}
	
	public function getModelList()
	{
		$this->db->select('id, name, short_name')->from('model_info')->order_by("id asc");
		return $this->db->get()->result();
	}
	
	public function newModelLibrary($user_id)
	{
		$this->db->where('user_id', $user_id);
		$this->db->delete('user_param_sets'); 
		return $this->db->affected_rows();
	}
	
	public function loadModelLibrary($user_id, $data)
	{
		foreach ($data as $i => $val) {
			$data[$i]["user_id"] = $user_id;
		}
		$this->db->insert_batch('user_param_sets', $data); 
		return $this->db->affected_rows();
	}
	
	public function getModelLibraryData($user_id)
	{	
		$this->db->select('model_id, name, data')->from('user_param_sets')->where("user_id", $user_id);
		return $this->db->get()->result_array();
	}
	
	public function getModelLibrary($user_id, $model_id = 0)
	{
		$this->db->select('model_info.id, model_info.name, model_info.short_name')->from('model_info')
			->join('user_param_sets', 'model_info.id = user_param_sets.model_id', 'left')
			->where('user_param_sets.user_id', $user_id)
			->or_where('model_info.id', $model_id)
			->order_by("id asc")->distinct();
		return $this->db->get()->result();
	}
	
	public function getModels()
	{
		$this->db->from('model_info')->order_by("id asc");
		return $this->db->get()->result();
	}

	public function getModelInfoById($id)
	{
		$this->db->from('model_info')->where("id", $id);
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->row();
		}
		
		return null;
	}

	public function getModelInfoByName($name)
	{
		$this->db->from('model_info')->where("name", $name);
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->row();
		}
		
		return null;
	}	
	
	public function getDefaultParamSets($model_id)
	{
		$this->db->select('id, name')->from('param_sets')->where("model_id", $model_id);
		$query = $this->db->get();

		return $query->result();
	}
	
	public function getDefaultParamSet($model_id, $id)
	{
		$this->db->select('data')->from('param_sets')->where(array("model_id" => $model_id, "id" => $id));
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			$result = $query->row();
			return $result->data;
		}
		
		return null;
	}
	
	public function getParamSets($user_id, $model_id)
	{
		$this->db->select('id, name')->from('user_param_sets')->where(array("user_id" => $user_id, "model_id" => $model_id));
		$query = $this->db->get();

		return $query->result();
	}
	
	public function getParamSet($user_id, $model_id, $id)
	{
		$this->db->select('data')->from('user_param_sets')->where(array("user_id" => $user_id, "model_id" => $model_id, "id" => $id));
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			$result = $query->row();
			return $result->data;
		}
		
		return null;
	}
	
	public function getParamSetByName($user_id, $model_id, $name)
	{
		$this->db->select('data')->from('user_param_sets')->where(array("user_id" => $user_id, "model_id" => $model_id, "name" => $name));
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			$result = $query->row();
			return $result->data;
		}
		
		return null;
	}
	
	public function addParamSet($user_id, $model_id, $name, $data)
	{
		$this->db->insert('user_param_sets', array("user_id" => $user_id, "model_id" => $model_id, "name" => $name, "data" => $data));
		return ($this->db->affected_rows() > 0 ? $this->db->insert_id() : -1);
	}
	
	public function updateParamSet($user_id, $model_id, $id, $data)
	{
		$this->db->where(array("id" => $id, "model_id" => $model_id, "user_id" => $user_id));
		$this->db->update('user_param_sets', array("data" => $data, "last_modify" => date('Y-m-d H:i:s')));
		return $this->db->affected_rows() > 0;
	}
	
	public function updateParamSetByName($user_id, $model_id, $name, $data)
	{
		$this->db->where(array("name" => $name, "model_id" => $model_id, "user_id" => $user_id));
		$this->db->update('user_param_sets', array("data" => $data, "last_modify" => date('Y-m-d H:i:s')));
		return $this->db->affected_rows() > 0;
	}	
	
	public function deleteParamSet($user_id, $model_id, $id)
	{
		$this->db->where(array("id" => $id, "model_id" => $model_id, "user_id" => $user_id));
		$this->db->delete('user_param_sets');
		return $this->db->affected_rows() > 0;
	}
	
	public function getModelBias($model_id)
	{
		$this->db->select('name, default')->from('model_bias')->where(array("model_id" => $model_id))->order_by('node_order', 'asc');
		$query = $this->db->get();
		return $query->result();
	}
		
	public function getModelParams($model_id)
	{
		$this->db->select('name, description, unit, default, editable, instance')->from('model_params')->where(array("model_id" => $model_id));
		$query = $this->db->get();
		return $query->result();
	}
			
	public function getModelOutputs($model_id)
	{
		$this->db->select('name, model_output, unit, column_id')->from('model_outputs')->where(array("model_id" => $model_id))->order_by('column_id', 'asc');
		$query = $this->db->get();
		return $query->result();
	}
}

?>
