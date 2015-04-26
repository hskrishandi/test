<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Modelsim_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->config->load('simulation');
	}

	/* * Benchmarking Test Model * */

	public function getBenchmarkingInfo($model_ID) {
		$query = $this->db->query("
			SELECT mb.id, mb.name,mb.display_name,
			COALESCE(outputs.filters, \"[]\") AS filter,
			COALESCE(variable.bias, \"[]\") AS variable_bias,
			COALESCE(fixed.bias, \"[]\") AS fixed_bias
			FROM `model_benchmark` AS mb
			LEFT JOIN
			(
			    SELECT mbo.benchmark_id AS id,
			    CONCAT('[', GROUP_CONCAT(
			        '{\"name\":\"', name, '\",\"unit\":\"', unit, '\",\"variable\":\"', variable, '\",\"column_id\":\"', column_id, '\"}' ORDER BY column_id SEPARATOR ','
			    ), ']') AS filters
				FROM `model_benchmark_outputs` AS mbo
				WHERE model_id= $model_ID
			    GROUP BY benchmark_id
			) AS outputs ON mb.id=outputs.id
			LEFT JOIN
			
			(
				SELECT mbo.benchmark_id AS id,
				CONCAT('[', GROUP_CONCAT(
					'{\"name\":\"', name, '\"}' ORDER BY orders SEPARATOR ','
				), ']') AS bias
				FROM `model_benchmark_bias` AS mbo
				WHERE variable=1
				GROUP BY benchmark_id
			) AS variable ON mb.id=variable.id
			LEFT JOIN
			(
				SELECT mbo.benchmark_id AS id,
				CONCAT('[', GROUP_CONCAT(
					'{\"name\":\"', name, '\"}' ORDER BY orders SEPARATOR ','
				), ']') AS bias
				FROM `model_benchmark_bias` AS mbo
				WHERE variable=0
				GROUP BY benchmark_id
			) AS fixed ON mb.id=fixed.id
			ORDER BY mb.orders");
		return $query->result_array();
	}
        	
	public function getBenchmarkingInfoById($id) {
		$query = $this->db->query("SELECT * FROM model_benchmark WHERE id=?", array($id));
		if($query->num_rows() > 0) return $query->row();
		return null;
	}

	public function getBenchmarkingBiases($id) {
		$query = $this->db->query("SELECT * FROM model_benchmark_bias WHERE benchmark_id=?", array($id));
		return $query->result();
	}

	public function getBenchmarkingOutputs($b_id,$m_id) {
		$query = $this->db->query("SELECT * FROM model_benchmark_outputs WHERE benchmark_id=? AND model_id=? ORDER BY column_id", array($b_id,$m_id));
		return $query->result();
	}

	public function getBenchmarkingControlSrc($b_id,$m_id) {
		$query = $this->db->query("SELECT * FROM model_benchmark_ctrl WHERE benchmark_id=? AND model_id=?  ORDER BY orders", array($b_id,$m_id));
		return $query->result();
	}		
			
	/* * Device Model * */			
			
	public function getModelsInfo()
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

	public function getModelInfoById2($id)
	{
		$this->db->from('model_info')->where("id", $id);
		return $this->db->get()->result();

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
	public function updatetModelInfo($data,$model_id){
		/*
		extract($data);
		$this->db->query("UPDATE  `imos2`.`model_info` SET  `name` =  '$name',
`short_name` =  '$short_name',
`icon_name` =  '$icon_name',
`desc_name` =  '$desc_name',
`organization` =  '$organization',
`type` =  '$type' WHERE  `model_info`.`id` ='$model_id'");
		
		*/
		
		$this->db->update('model_info',$data,array('id' => $model_id));
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
    
	public function getModelCardInfo($model_card_name)
	{
		$this->db->select('user_param_sets.data as param_data')->from('user_param_sets')
			 ->where('user_param_sets.name', $model_card_name);	

		return $this->db->get()->result();
	}

	public function getModelCardInfo2($model_card_name, $user_id)
	{
		$this->db->select('user_param_sets.data as param_data')->from('user_param_sets')
			 ->where(array('user_param_sets.name' => $model_card_name, 'user_id' => $user_id));	

		return $this->db->get()->result();
	}

	public function getModelLibrary($user_id)
	{
		$this->db->select('model_info.id as model_id, model_info.short_name as model_name, user_param_sets.id as id, user_param_sets.name, user_param_sets.data')->from('model_info')
			->join('user_param_sets', 'model_info.id = user_param_sets.model_id', 'left')
			->where('user_param_sets.user_id', $user_id)			
			->order_by("model_id asc")->distinct();

		return $this->db->get()->result();
	}
    	
	public function getModelLibraryEntry($user_id, $id)
	{
		$this->db->select('data')->from('user_param_sets')->where(array("user_id" => $user_id, "id" => $id));
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			$result = $query->row();
			return json_decode($result->data);
		}
		
		return null;
	}
		
	public function addModelLibraryEntry($user_id, $model_id, $name, $data)
	{
		$this->db->select('id')->from('user_param_sets')->where(array("user_id" => $user_id, "model_id" => $model_id, "name" => $name));
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			$result = $query->row();
			$this->deleteModelLibraryEntry($user_id, $result->id);
		}
		
		$this->db->insert('user_param_sets', array("user_id" => $user_id, "model_id" => $model_id, "name" => $name, "data" => $data));
		return ($this->db->affected_rows() > 0 ? $this->db->insert_id() : -1);
	}
		
	public function deleteModelLibraryEntry($user_id, $id)
	{
		$this->db->where(array("id" => $id, "user_id" => $user_id));
		$this->db->delete('user_param_sets');
		return $this->db->affected_rows() > 0;
	}
	
	public function newModelLibrary($user_id)
	{
		$this->db->where('user_id', $user_id);
		$this->db->delete('user_param_sets'); 
		return $this->db->affected_rows();
	}
	
	public function loadModelLibrary($user_id, $data)
	{
		$insert = array();
		
		foreach ($data as $i => $val) {
			$insert[$i] = array();
			$insert[$i]["user_id"] = $user_id;
			$insert[$i]["data"] = $data[$i]["data"];
			$insert[$i]["name"] = $data[$i]["name"];
			$insert[$i]["model_id"] = $data[$i]["model_id"];
		}
		
		$this->db->insert_batch('user_param_sets', $insert); 
		return $this->db->affected_rows();
	}
        
	public function getParamSets($model_id)
	{
		$this->db->select('id, name')->from('param_sets')->where("model_id", $model_id);
		$query = $this->db->get();

		return $query->result();
	}
	
	public function getParamSet($model_id, $id)
	{
		$this->db->select('data')->from('param_sets')->where(array("model_id" => $model_id, "id" => $id));
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			$result = $query->row();
			return $result->data;
		}
		
		return null;
	}
		
	public function getModelBiases($model_id)
	{
		$this->db->select('name, default')->from('model_bias')->where(array("model_id" => $model_id))->order_by('node_order', 'asc');
		$query = $this->db->get();
		return $query->result();
	}
		
	public function getModelParams($model_id, $editable = true)
	{
		$this->db->select('name, description, unit, default, instance')->from('model_params')
				->where(array("model_id" => $model_id, "editable" => $editable))
				->order_by('instance', 'asc');
		
		$query = $this->db->get();
		$ret = array('instance' => array(), 'model' => array());
		$result = $query->result();
		
		foreach ($result as $param) {
			if ($param->instance == 1) {
				$ret['instance'][] = $param;
			} else {
				$ret['model'][] = $param;
			}
		}
		return $ret;
	}

	public function getModelInstanceParams($model_id, $editable = true)
	{
		$this->db->select('name, description, unit, default, instance')->from('model_params')
				->where(array("model_id" => $model_id, "editable" => $editable, "instance" =>1))
				->order_by('instance', 'asc');
		
		$query = $this->db->get();
		$ret = array('instance' => array());
		$result = $query->result();
		
		foreach ($result as $param) {
			if ($param->instance == 1) {
				$ret['instance'][] = $param;
			} 
		}
		return $ret;
	}
	
	public function getModelParamsTabTitle($model_id)
	{
		$this->db->select('instance,title')->from('model_params_tab_title')
		->where(array("model_id" => $model_id))
		->order_by('instance', 'asc');
		
		$query = $this->db->get();
    $ret = array();
		$result = $query->result();
		
		foreach ($result as $param) {
      $ret[$param->instance] = $param->title;
		}
		
		return $ret;
	}
			
	public function getModelOutputs($model_id)
	{
		$this->db->select('id, name, unit, variable, column_id')->from('model_outputs')->where(array("model_id" => $model_id))->order_by('column_id', 'asc');
		$query = $this->db->get();
		return $query->result();
	}	

/*		
	User library
	
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
	
	public function deleteParamSet($user_id, $model_id, $id)
	{
		$this->db->where(array("id" => $id, "model_id" => $model_id, "user_id" => $user_id));
		$this->db->delete('user_param_sets');
		return $this->db->affected_rows() > 0;
	}

*/
}

?>
