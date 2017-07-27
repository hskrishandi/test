<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Realcas_service extends Base_service
{
    private $_simuroot = "/local/html/tmp/ngspice";

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Repositories/Realcas_repository');
        $this->realcasModels = array(10);
    }

    /**
     *  The following functions are for model library (site menu in realcas)
     */
    public function getModelLibrary($userId, $modelId = 0)
    {
        if ($modelId == 0) {
            $models = $this->Realcas_repository->getModelLibrary($userId);

            $response = array();
            foreach ($models as $model) {
                // In realcas, there are only some models are allowed
                if (in_array($model->model_id, $this->realcasModels)) {
                    if (!array_key_exists($model->model_name, $response)) {
                        $response[$model->model_name] = array(
                            'id' => $model->model_id,
                            'name' => $model->model_name,
                            'library' => array()
                        );
                    }
                    $response[$model->model_name]['library'][] = array('id' => $model->id, 'name' => $model->name);
                }
            }

            $response_array = array();
            foreach ($response as $item) {
                $response_array[] = $item;
            }
            $response = $response_array;
        } else {
            $response = $this->Realcas_repository->getModelLibraryEntry($userId, $modelId);
        }

        return $response;
    }

    public function addModelLibraryEntry($userId, $modelId, $name, $data)
    {
        return $this->Realcas_repository->addModelLibraryEntry($userId, $modelId, $name, $data);
    }

    public function deleteModelLibraryEntry($userId, $modelId) {
        return $this->Realcas_repository->deleteModelLibraryEntry($userId, $modelId);
    }

    public function newModelLibrary($userId) {
        return $this->Realcas_repository->newModelLibrary($userId);
    }

    public function loadModelLibrary($userId, $data) {
        $insert = array();
        foreach ($data as $i => $val) {
            $insert[$i] = array();
            $insert[$i]["user_id"] = $userId;
            $insert[$i]["data"] = $data[$i]["data"];
            $insert[$i]["name"] = $data[$i]["name"];
            $insert[$i]["model_id"] = $data[$i]["model_id"];
        }

        return $this->Realcas_repository->loadModelLibrary($insert);
    }

    public function updateModelLibraryEntry($user_id, $id, $model_id, $data, $newName)
    {
        return $this->Realcas_repository->updateModelLibraryEntry($user_id, $id, $model_id, $data, $newName);
    }

    /**
     * The following functions are for simulation
     */
    public function getAllModelCard($userId) {
        $modelData = $this->Realcas_repository->getAllModelCard($userId);
        $stringModels = "";
        foreach($modelData as $modelset){
            $modelType = null;
            $modelParamName = $this->Txtsim_model->getModelParamName($modelset->model_id);
            $modelParamNameSet = null;
            $allParamSet = json_decode($modelset->user_param_data);
            foreach($modelParamName as $Name){
                foreach($allParamSet as $ParamSet){
                    if($modelset->model_id == '10' && strtolower($ParamSet->name) == 'type')	{
                        $modelType = $ParamSet->value;
                        continue;
                    }
                    if (strtolower($ParamSet->name) == strtolower($Name->name))
                        $modelParamNameSet[] = $ParamSet;
                }
            }

            //$stringModel = ".MODEL ".$modelset->model_short_name.".".$modelset->library_name." ". $modelset->model_name;
            $stringModel = ".MODEL ".$modelset->model_short_name.".".$modelset->library_name." ";
            if($modelset->model_id == '10' && $modelType != null){
                $stringModel = $stringModel.($modelType == '1' ? 'nmos':'pmos');
            }
            else
                $stringModel = $stringModel. $modelset->model_name;

            if ($modelParamNameSet!==null){
                foreach ($modelParamNameSet as $value)
                    $stringModel .= (" ".strtolower($value->name) . "=" . $value->value);
            }
            $stringModels .= $stringModel."\n";
        }
        //$stringModels;
        return $stringModels;
    }

    public function netlistCheck($netlist) {
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

    public function replacePlotToWRDATA(&$netlist)
    {
        //Parsing the plot commard in CONTROL CARDS
        return preg_replace_callback('/^plot/im', create_function('$matchs','global $count1; return "wrdata output".$count1++.".data";'), $netlist);
    }

    public function runSPICES($netlistfile, $netlist = null) {
        $uuid = uniqid('', true);
        $folder = $this->_simuroot . $uuid;
        mkdir($folder,0777);
        write_file($folder.'/netlist.sp',$netlistfile);
        if($netlist !== null)
            write_file($folder."/netlist", $netlist);

        $this->SetWorkingFolder($folder);
        $this->RunBgProcess($this->config->item('realcas') . " -b netlist.sp", $pid, true);
        if($pid != -1) {
            $this->RecordPID($pid);
            return array("id" => $uuid);
        }
        return null;
    }

    public function spiceStatus($uuid)
    {
        $folder = $this->_simuroot . $uuid;
        $response = array("status" => "NULL");
        $response["uuid"] = $uuid;
        $this->SetWorkingFolder($folder);
        if($this->GetPID($pid))
        {
            $response["pid"] = $pid;
            if($this->IsProcessRunning($pid, "ngspice"))
                $response["status"] = "RUNNING";
            else if($this->IsProcessKilled())
                $response["status"] = "KILL";
            else if(($log = $this->ReadOutput()) !== null) {
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
        $this->SetWorkingFolder($folder);
        if($this->GetPID($pid))
        {
            return $this->AbortProcess($pid, "ngspice");
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
                // $item['table_data'] = $this->spice_result_to_table($this->_simuroot . $uuid . "/" . $item['filename']);
            }else{
                $item['error'] = "true";
                //$result['log'] .= "</br>Error: Cannot find (one of) vectors - " .$item['ylabel'];
            }
            $result['dataset'][]=$item;
            //read data
        }
        $this->parseHCI($uuid, $result);
    }

    /**
     * Parse HCI output file
     *
     * @param $uuid - simulation id, used to locate simulation folder under /local/html/tmp
     * @param &$result - $result address, passing address will directly modify $result within this function
     *
     * @author Leon
     */
    public function parseHCI($uuid, &$result)
    {
        $path = $this->_simuroot . $uuid . "/" . $this->config->item('hci');
        $data = read_file($path);
        if ($data) {
            $rows = explode("\n", $data);
            $devices = array();
            foreach ($rows as $row) {
                if ($row == "") continue; // remove empty lines
                $column = preg_split('/\s+/', $row);
                if (count($column) >= 3) {
                    if (!$devices[$column[0]]['filename']) {
                        $devices[$column[0]]['filename'] = $this->config->item('hci');
                    }
                    if (!$devices[$column[0]]['ylabel']) {
                        $devices[$column[0]]['ylabel'] = $column[0] . "[dVth]";
                    }
                    if (!$devices[$column[0]]['xlabel']) {
                        $devices[$column[0]]['xlabel'] = "year";
                    }
                    $devices[$column[0]]['error'] = "false";
                    $devices[$column[0]]['data'][] = array($column[3], $column[2]);
                } else {
                    $devices[$column[0]]['error'] = "true";
                }
            }
            foreach ($devices as $key => $device) {
                $result['dataset'][] = $device;
            }
        }
    }

    /**
     * The following functions are used for process
     */
    // current working folder
    private $_workingfolder = "";

    private $_tmpname = array(
        "processid" => "process.pid",		//the filename of the process id stored
        "status" => "process.status",		//the filename of the process status stored
        "output" => "process.output"		//the file name of the process output stored
    );

    /**
     * Run Background Process (non-blocking connection)
     * @param string $cmd 		command to be run in background
     * @param string $pid 		get the process id
     * @param boolean $ret		whether require the process output
     * @return boolean whether the process running success
     */
    public function RunBgProcess($cmd, &$pid, $ret = false)
    {
        if($ret)
            exec("$cmd > " . $this->_tmpname["output"] . " 2>&1 & echo $!", $output);
        else
            exec("$cmd > /dev/null 2>&1 & echo $!", $output);

        if($output)
        {
            $pid = $output[0];
            return true;
        }
        $pid = "-1";
        return false;
    }

    /**
     * Check the Process is running with matching id and name
     * @param string $pid 		the process id
     * @param string $processName 	the process name
     * @return boolean whether the process is running
     */
    public function IsProcessRunning($pid, $processName)
    {
        exec("ps -p $pid", $result);
        if(isset($result[1]) && preg_match("/$processName/", $result[1]) !== false)
            return true;
        return false;
    }

    /**
     * Record the process id in a folder
     * @param string $folder 	the location the pid stored
     * @param string $pid		the process id
     * @return boolean whether the record is success
     */
    public function RecordPID($pid, $folder = null)
    {
        $folder = $this->_GetWorkingFolder($folder);

        if(file_put_contents("$folder/" . $this->_tmpname["processid"], $pid) !== false)
            return true;
        return false;
    }

    /**
     * Get the pid in a folder
     * @param string $folder	the location the pid stored
     * @return boolean whether the pid get
     */
    public function GetPID(&$pid, $folder = null)
    {
        $folder = $this->_GetWorkingFolder($folder);
        if(is_file("$folder/process.pid"))
        {
            $pid = file_get_contents("$folder/" . $this->_tmpname["processid"]);
            return true;
        }
        return false;
    }

    /**
     * Abort the process with matching id and name
     * @param string $folder	the location the status stored
     * @param string $pid 		the process id
     * @param string $processName	the process name
     * @return boolean whether the process is abort
     */
    public function AbortProcess($pid, $processName, $folder = null)
    {
        $folder = $this->_GetWorkingFolder($folder);
        if($this->IsProcessRunning($pid, $processName))
        {
            file_put_contents("$folder/" . $this->_tmpname["status"], "KILL");
            exec("kill -9 $pid");
            return true;
        }
        return false;
    }

    /**
     * Check whether the process is killed
     * @param string $folder	the location the status stored
     * @return boolean
     */
    public function IsProcessKilled($folder = null)
    {
        $folder = $this->_GetWorkingFolder($folder);
        if(is_file("$folder/" . $this->_tmpname["status"]))
        {
            $content = file_get_contents("$folder/" . $this->_tmpname["status"]);
            if(preg_match("/KILL/", $content) !== false)
                return true;
        }
        return false;
    }

    public function ReadOutput($folder = null)
    {
        $folder = $this->_GetWorkingFolder($folder);
        if(is_file("$folder/" . $this->_tmpname["output"]))
        {
            return file_get_contents("$folder/" . $this->_tmpname["output"]);
        }
        return null;
    }


    private function _GetWorkingFolder($folder)
    {
        if($folder == null)
            return $this->_workingfolder;
    }

    public function SetWorkingFolder($folder)
    {
        $this->_workingfolder = $folder;
        chdir($folder);
    }
	
}
