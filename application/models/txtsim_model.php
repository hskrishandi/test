<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Txtsim_model extends CI_Model{

	private $_simuroot = "/local/html/tmp/ngspice";
	
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('file');
		$this->load->model('process_model');
	}
	
	public function netlistGen($modelCard)
	{
		return $this->load->view('txtsim/txtsim_temple.php',array_merge($this->input->post(), array("modelCard"=>$modelCard)),true);
	}
	public function replacePlotToWRDATA(&$netlist)
	{
		//Parsing the plot commard in CONTROL CARDS
		return preg_replace_callback('/^plot/im',create_function('$matchs','global $count1; return "wrdata output".$count1++.".data";'),$netlist);
	}
	public function NetlistCheck($netlist){
		//Check the netlist without .end
		$matches = null;
		preg_match("/.end$/i", $netlist, $matches);
		if (count($matches) === 0) $netlist .= "\n.end";
		
		//Check if no control card
		$matches = null;
		global $plotstring;
		preg_match("/.control/i", $netlist, $matches);
		if (count($matches) === 0){
			$pos = stripos($netlist,'.end');
			$netlist = substr($netlist, 0, $pos)."\n.CONTROL\nsave all\nrun\n.endc\n".substr($netlist, $pos);
		}
		
		//replace all the comment plot
		$netlist = preg_replace("/\*( +)?\.plot.+/im", "", $netlist);
		//MOVE .plot to .CONTROL card
		$netlist = preg_replace_callback('/\.plot[^\n]+/im',create_function('$matchs','global $plotstring; $plotstring.=substr($matchs[0],1)."\n";return "";'),$netlist);
		//append the control card
		$pos = stripos($netlist,'.endc');
		$netlist = substr($netlist, 0, $pos).$plotstring.substr($netlist, $pos);
		
		//Command out the Harard Commard
		$hazard_commands = array("edit", "shell", "cd", "jobs", "while", "repeat", "dowhile", "foreach");
		foreach($hazard_commands as $command) {
			$netlist = preg_replace_callback('/(?<= |\n|\r)' . $command . '( |\n|\r)/im',create_function('$matchs','return "*".$matchs[0];'),$netlist);
		}
		
		
		return $netlist;
	}
	public function getAllModelCard(){
		$user_id = $this->Account_model->islogin()->id;
		$this->db->select('user_param_sets.model_id AS "model_id", model_info.short_name  AS "model_short_name",model_info.name AS "model_name", user_param_sets.name AS "library_name", user_param_sets.data AS "user_param_data"')
		->from('user_param_sets')->join('model_info', 'user_param_sets.model_id=model_info.id')
		->where(array('user_param_sets.user_id' => $user_id));
		$query = $this->db->get();
		$stringModels = "";
		
		foreach($query->result() as $modelset){
			$modelParamName = $this->Txtsim_model->getModelParamName($modelset->model_id);
			$modelParamNameSet = null;
			$allParamSet = json_decode($modelset->user_param_data);
			foreach($modelParamName as $Name){
				foreach($allParamSet as $ParamSet){
					if (strtolower($ParamSet->name) == strtolower($Name->name))
						$modelParamNameSet[] = $ParamSet;
				}
			}
			
			$stringModel = ".MODEL ".$modelset->model_short_name.".".$modelset->library_name." ". $modelset->model_name;
			if ($modelParamNameSet!==null){
				foreach ($modelParamNameSet as $value)
					$stringModel .= (" ".strtolower($value->name) . "=" . $value->value);
			}
			$stringModels .= $stringModel."\n";
		}
		//$stringModels;
		return $stringModels;
		
	}

	public function getModelParamName($model_id)
	{
		$this->db->select('name')->from('model_params')->where(array("model_id" => $model_id,"instance" => "0"));
		$query = $this->db->get();
		//var_dump($query->result());
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		
		return null;
	}
	public function spice_result_to_table($path){
		$string = read_file($path);
		$rows = explode("\n",$string);
		$process_array = null;
		foreach($rows as $row){
			if ($row == "") continue;
			//$row = substr($row, 1, -1);
			preg_match_all('/([-+]*[\d.]+e[-+]*[\d]+)+/m',$row, $match);
			$process_array[] = $match[0];
		}
		$result_array = null;
		return $process_array;
	}
	public function spice_result_to_array($path){
		$string = read_file($path);
		$rows = explode("\n",$string);
		$process_array = null;
		foreach($rows as $row){
			if ($row == "") continue;
			//$row = substr($row, 0, -1);
			preg_match_all('/([-+]*[\d.]+e[-+]*[\d]+)+/m',$row, $match);
			//var_dump($match[0]);
			$process_array[] = $match[0];
		}
		$result_array = null;
		for ($i = 0; $i < count($process_array[0])/2; $i++){
			foreach($process_array as $row){
				$result = null;
				$result[0] =$row[2*$i];
				$result[1] = $row[(2*$i)+1];
				$result_array[] = $result;
			}
		}

		return $result_array;
	}
	
	public function spice_result_to_CSV($uuid, $file){
		$data = $this->spice_result_to_table($this->_simuroot . $uuid . "/" . $file);
		$string = null;
		foreach ($data as $row){
			for ($i = 0; $i < count($row); $i++){
				if ($i===0){
					$string .= $row[$i];
				} else if (($i%2)===1){
					$string .= $row[$i];
				} else{
					continue;
				};
				if ($i < (count($row)-1))$string.=",";
			}
			$string .= "\r\n";
		}
		return $string;
	}
	
	public function spiceStatus($uuid)
	{
		$folder = $this->_simuroot . $uuid; 
		$response = array("status" => "NULL");
		$this->process_model->SetWorkingFolder($folder);
		if($this->process_model->GetPID($pid))
		{
			if($this->process_model->IsProcessRunning($pid, "ngspice"))
				$response["status"] = "RUNNING";
			else if($this->process_model->IsProcessKilled())
				$response["status"] = "KILL";
			else if(($log = $this->process_model->ReadOutput()) !== null) {
				$response["status"] = "FINISHED";
				$response["log"] = $log;
				$response["uuid"] = $uuid;
				$this->parseOutput($uuid, $response);
			}
		}
		
		return $response;
	}
	
	public function spiceStop($uuid)
	{
		$folder = $this->_simuroot . $uuid; 
		$this->process_model->SetWorkingFolder($folder);
		if($this->process_model->GetPID($pid))
		{
			return $this->process_model->AbortProcess($pid, "ngspice");
		}
		return true;
	}
	
	private function parseOutput($uuid, &$result)
	{
		$netlist = file_get_contents($this->_simuroot . $uuid . "/netlist.sp");
		if(is_file($this->_simuroot . $uuid . "/netlist"))
			$result["netlist_file"] = file_get_contents($this->_simuroot . $uuid . "/netlist");
		$LOG = preg_split('/\n/', $result['log']);
		$result['log'] = '';
		foreach ($LOG as $value){
			if ($value == 'Note: No ".plot", ".print", or ".fourier" lines; no simulations run') continue;
			if ($value == "Note: can't find init file.") continue;
			$result['log'] .= $value . "</br>";
		}
		
		if($netlist)
			$result['netlist'] = $netlist;
		else
			$result['netlist'] = "error";
		
		$match = null;
		$result['dataset'] = null;
		$result["error"] = false;
		preg_match_all('/wrdata\s[^\n^\r]+$\R?^/m',$netlist,$match,PREG_PATTERN_ORDER,0);
		foreach($match[0] as $dataset){
			$items = preg_split('/\s/m',$dataset);
			$item['filename'] = $items[1].".data";

			$item['ylabel'] = "";
			for ($i=2; $i<count($items)-1; $i++){
				$item['ylabel'] .=  $items[$i]." ";
			}
			$item['xlabel'] = "";
			if (read_file($this->_simuroot . $uuid . "/" . $item['filename'])){
				$item['error'] = "false";
				$item['data'] = $this->spice_result_to_array($this->_simuroot . $uuid . "/" . $item['filename']);
				$item['table_data'] = $this->spice_result_to_table($this->_simuroot . $uuid . "/" . $item['filename']);
			}else{
				$item['error'] = "true";
				//$result['log'] .= "</br>Error: Cannot find (one of) vectors - " .$item['ylabel'];
			}
			$result['dataset'][]=$item;
			//read data
		}
	}
	
	public function runSPICES($netlistfile, $netlist = null){
		$uuid = uniqid('', true);
		$folder = $this->_simuroot . $uuid; 
		mkdir($folder,0777);
		write_file($folder.'/netlist.sp',$netlistfile);
		if($netlist !== null)
			write_file($folder."/netlist", $netlist);
		
		$this->process_model->SetWorkingFolder($folder);
		$this->process_model->RunBgProcess($this->config->item('ngspice') . " -b netlist.sp", $pid, true);
		if($pid != -1) {
			$this->process_model->RecordPID($pid);
			return array("id" => $uuid);
		}
		return null;
	}
}

$plotstring = "";
