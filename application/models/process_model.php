<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class process_model extends CI_Model { 
	
	/**
	 * current working folder
	 */
	private $_workingfolder = "";
	
	private $_tmpname = array(
		"processid" => "process.pid",		//the filename of the process id stored
		"status" => "process.status",		//the filename of the process status stored
		"output" => "process.output"		//the file name of the process output stored
	);
	
	public function __construct()
	{
		parent::__construct();
	}
	
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
	
	/**
	 * Read the generated output
	 * @param string $folder	the location the output stored
	 * @return string about the saved output
	 */
	public function ReadOutput($folder = null)
	{
		$folder = $this->_GetWorkingFolder($folder);
		if(is_file("$folder/" . $this->_tmpname["output"]))
		{
			return file_get_contents("$folder/" . $this->_tmpname["output"]);
		}
		return null;
	}
	
	/**
	 * Check if the custom folder selected, else return default _workingfolder
	 * @param string $folder	the location of custom folder
	 * @return string about the full path of working folder
	 */
	private function _GetWorkingFolder($folder)
	{
		if($folder == null)
			return $this->_workingfolder;
		else
			return $folder;
	}
	/**
	 * Save the workingfolder path and set shell root to the working folder
	 * @param string $folder	the location of working folder
	 * @return n/a
	 */
	public function SetWorkingFolder($folder)
	{
		$this->_workingfolder = $folder;
		chdir($folder);
	}
	
}

