<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ngspice_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->config->load('simulation');
		$this->load->library('parser');
		$this->load->model('simulation_model');
	}
	
	protected function run_spice($cwd, $file)
	{
		$file = realpath($cwd . '/' . $file);
		if (!file_exists($file)) return null;

		exec($this->config->item('ngspice') . " -b " . $file, $output, $ret);
		
		return $output;
	}

	public function simulate($id, $param, $bias)
	{
		$netlist = $this->get_netlist($id, $param, $bias);
		
		if ($netlist == null) return;
	
		/* Save netlist file to tmp */
	
		$path = getcwd();
		$id = uniqid('sim_', true);
		$tmp_folder = realpath($path . '/application/simulation/tmp/') . '/' . $id;
		
		$old = umask(0);
		
		mkdir($tmp_folder, 0777);
		
		file_put_contents($tmp_folder . '/netlist.sp', $netlist);
		chdir($tmp_folder);
		chmod('./netlist.sp', 0777);
		
		umask($old);
		
		/* Run ngspice */
		if ($this->run_spice($tmp_folder, 'netlist.sp')) {
			return $id;
		}
		
		return null;
	}
	
	protected function get_netlist($id, $param, $bias)
	{
		$model_info = $this->Simulation_model->getModelInfoById($id);
		if ($model_info == null) {
			return null;
		}
		
		$model_bias = $this->Simulation_model->getModelBias($id);
		$model_params = $this->Simulation_model->getModelParams($id);
		$model_outputs = $this->Simulation_model->getModelOutputs($id);

		/* Generate netlist file */
		
		$sources = array();
		foreach ($model_bias as $v) {
			$sources[strtolower($v->name)] = $v->default;
		}
		for ($i = 1; $i <= 2; ++$i) {
			$key = $bias['b'.$i]['type'];
			if (array_key_exists($key, $sources)) {
				$sources[$key] = $bias['b'.$i]['value'];
			}
		}
		
		$simulate = 'dc ' . $bias['v1']['type'] . ' ' . $bias['v1']['init'] . ' ' . $bias['v1']['end'] . ' ' . $bias['v1']['step'];
		if (array_key_exists('v2', $bias)) {
			$simulate .=  ' ' . $bias['v2']['type'] . ' ' . $bias['v2']['init'] . ' ' . $bias['v2']['end'] . ' ' . $bias['v2']['step'];
		}		
		
		$inst_name = sprintf($model_info->var, 1);
		$inst_def =  $inst_name . ' ';
		$model_def = '.model ' . $model_info->name . ' ' . $model_info->model_name . ' ';
		
		$source_str = '';
		foreach ($sources as $k => $v) {
			$s = strtolower($k);
			$inst_def .= $s . ' ';
			$source_str .= $s . ' ' . $s . ' 0 ' . $v . "\n";
		}
		
		$inst_def .= $model_info->name . ' ';

		foreach ($model_params as $v) {
			$name = strtolower($v->name);
			$str = $v->name . '=' . (array_key_exists($name, $param) ? $param[$name] : $v->default) . ' ';
			if ($v->instance) {				
				$inst_def .= $str;
			} else {
				$model_def .= $str;
			}
		}
		
		$saves = "save ";
		$wrdata = 'wrdata output ';
		foreach ($model_outputs as $v) {
			$ngspice_var = ($v->model_output ? '@' . $inst_name . '[' . $v->name .']' : $v->name);
			$saves .=  $ngspice_var . ' ';
			$wrdata .= $ngspice_var . ' ';
		}
		$saves .= "\nsave all";
		
		ob_start();
		
		include(realpath(getcwd() . '/application/simulation/netlist.tpl'));
		
		$netlist = ob_get_contents();
		$netlist = $this->parser->parse_string($netlist, array('save' => $saves, 'output' => $wrdata, 'source' => $source_str, 'simulate' => $simulate, 'model' => $model_def, 'instance' => $inst_def), true);
		
		ob_end_clean();
		
		return $netlist;
	}
	
	public function get_output($token, $output_id)
	{
		$result = array();
		$data_rows = file(realpath(getcwd() . '/application/simulation/tmp/') . '/' . $token . '/output.data', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
		
		foreach ($data_rows as $row) {
			$cols = preg_split("/[\s]+/", trim($row));
			$result[] = array(floatval(trim($cols[floor($output_id/2)*2])), floatval(trim($cols[$output_id])));
		}
		
		return $result;
	}
}

?>
