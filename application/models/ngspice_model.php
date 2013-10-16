<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ngspice_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->config->load('simulation');
		$this->load->library('parser');
		$this->load->model('process_model');
	}

	public function simulate($netlist)
	{
		// Save netlist file to tmp
		$id = uniqid('sim_', true);
		$folder = realpath(getcwd() . '/application/simulation/tmp/') . '/' . $id;
		
		$old = umask(0);
		
		mkdir($folder, 0777);
		file_put_contents($folder . '/netlist.sp', $netlist);
		chmod($folder . '/netlist.sp', 0777);
		
		umask($old);
		
		// Run ngspice *
		$cmd = $this->config->item('ngspice') . " -b netlist.sp";
		$this->process_model->SetWorkingFolder($folder);
		$this->process_model->RunBgProcess($cmd, $pid);
		if ($pid != -1) {
			$this->process_model->RecordPID($pid);
			return array("id" => $id);
		}
		
		return null;
	}
	
	public function spiceStatus($uuid)
	{
		$folder = realpath(getcwd() . '/application/simulation/tmp/') . '/' . $uuid;
		$status = "NULL";
		$this->process_model->SetWorkingFolder($folder);
		if($this->process_model->GetPID($pid))
		{
			if($this->process_model->IsProcessRunning($pid, "ngspice"))
				$status = "RUNNING";
			else if($this->process_model->IsProcessKilled())
				$status = "KILL";
			else
				$status = "FINISHED";
		}
		
		return array("status" => $status);
	}
	
	public function spiceStop($uuid)
	{
		$folder = realpath(getcwd() . '/application/simulation/tmp/') . '/' . $uuid;
		$this->process_model->SetWorkingFolder($folder);
		if($this->process_model->GetPID($pid))
		{
			return $this->process_model->AbortProcess($pid, "ngspice");
		}
		return true;
	}
	
	/**
	 * Generate netlist for model simulation based on input array
	 * Input format:
	 * array(
	 *   prefix => [instance name prefix],
	 *   iname => [instance name],
	 *   mname => [model name],
	 *   type => [model type],
	 *   sources => array(array(name, value), ...),
	 *   iparams => array(array(name, value), ...),
	 *   mparams => array(array(name, value), ...),
	 *   outputs => [string],
	 *   varsources => array[2](array(name, init, end, step), ...)
	 * )
	 * 
	 * KEY: iparams = instance parameters; mparams = model parameters; varsources = variable sources
	 */
	public function getNetlistForModelSim($input)
	{
		// Var sources can be atmost 2
		if (count($input['varsources']) > 2) {
			$input['varsources'] = array($input['varsources'][0], $input['varsources'][1]);
		}
		
		ob_start();
		
		include(realpath(getcwd() . '/application/simulation/netlist.tpl'));
		
		$netlist = ob_get_contents();
		$netlist = $this->parser->parse_string($netlist, $input, true);
		$netlist = $this->parser->parse_string($netlist, $input, true);	// double pass for bug fix
		
		ob_end_clean();
		
		return $netlist;
	}
	
	public function getData($token, $column_id)
	{
		$startx = 0;
		$plot = -1;
		$result = array();
		$filepath = realpath(getcwd() . '/application/simulation/tmp/') . '/' . $token . '/output.data';
		
		if (!file_exists($filepath)) {
			return $result;
		}
		
		$data_rows = file($filepath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
		
		foreach ($data_rows as $row) {
			$cols = preg_split("/[\s]+/", trim($row));
			$point = array(trim($cols[floor($column_id/2)*2]), trim($cols[$column_id]));
			if (empty($result) || $point[0] == $startx) {
				// first point
				$startx = $point[0];
				$result[++$plot] = array();
			}
			$result[$plot][] = array(floatval($point[0]), floatval($point[1]));
		}
		
		return $result;
	}
}

?>
