<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class txtsim extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->library(array('jsonRPCServer'));
		$this->load->helper(array('template_inheritance', 'html', 'credits', 'form', 'url', 'download','file'));
		$this->load->model(array('Account_model', 'Discussion_model',"Txtsim_model",'Simulation_model'));
		
	}
	
	public function index()
	{
		if (!$this->Account_model->isAuth()) return;
		$user_info = $this->Account_model->isLogin();
		$data = array(
			'models' => ($user_info ? $this->Simulation_model->getModelLibrary($user_info->id) : array()), 
			'model_list' => $this->Simulation_model->getModels()
		);
		//var_dump($data);
		$this->load->view('txtsim/txtsim.php',$data);
	}
	public function convNetlistToRAW()
	{
		if (!$this->Account_model->isAuth()) return;
		$modelcard = $this->Txtsim_model->getAllModelCard();
		$netlist = $this->Txtsim_model->netlistGen($modelcard);
		echo json_encode(array("error" => false, "netlist"=>$netlist),JSON_NUMERIC_CHECK);
	}

	
	public function runNetlistSIM(){
		if (!$this->Account_model->isAuth()) return;
		$netlist = null;
		$modelcard = $this->Txtsim_model->getAllModelCard();
		$netlist = $this->Txtsim_model->netlistGen($modelcard);
		$netlist = $this->Txtsim_model->NetlistCheck($netlist);
		$netlist_file = $this->Txtsim_model->replacePlotToWRDATA($netlist);
		echo json_encode($this->Txtsim_model->runSPICES($netlist_file),JSON_NUMERIC_CHECK);
	}
	public function runRAWSIM(){
		if (!$this->Account_model->isAuth()) return;
		$netlist = $this->input->post('RAWlist');
		$netlist = $this->Txtsim_model->NetlistCheck($netlist);
		$netlist_file = $this->Txtsim_model->replacePlotToWRDATA($netlist);
		echo json_encode($this->Txtsim_model->runSPICES($netlist_file, $netlist),JSON_NUMERIC_CHECK);
	}
	
	public function simulationStatus()
	{
		if (!$this->Account_model->isAuth()) $this->output->set_status_header('401');
		else if(!$this->input->post()) $this->output->set_status_header('405');
		else
		{
			$uuid = $this->input->post('session', true);
			$response = $this->Txtsim_model->spiceStatus($uuid);
			echo json_encode($response,JSON_NUMERIC_CHECK);
		}
	}
	
	public function simulationStop()
	{
		if (!$this->Account_model->isAuth()) $this->output->set_status_header('401');
		else if(!$this->input->post()) $this->output->set_status_header('405');
		else
		{
			$uuid = $this->input->post('session', true);
			$response = $this->Txtsim_model->spiceStop($uuid);
		}
	}
	
	public function loadRAW(){
		$config['upload_path'] = './uploads/txtsim';
		$config['allowed_types'] = 'sp';
		$this->load->library('upload',$config);
		$this->upload->do_upload("RAWupload");
		$data = $this->upload->data();
		$string = read_file($data['full_path']);
		$updata = $this->upload->data();
		if ($string && $this->upload->file_ext ===".sp"){
			echo json_encode(array_merge(array("error" => false, "netlist"=>$string)),JSON_NUMERIC_CHECK);
		}else{
			echo json_encode(array_merge(array("error" => true, "a" => $string, "b" =>  $this->upload->file_type)),JSON_NUMERIC_CHECK);
		}
	}
	public function saveRAW($filename = 'netlist'){
		if (!$this->Account_model->isAuth()) return;
		$netlist1 = $this->input->post('RAWlist');
		//conv the \n to \r\n at EOL for fitting the NOTEPAD in windows
		$netlist = preg_replace("/\n/","\r\n", $netlist1);
		force_download($filename . '.sp', $netlist);
	}
	public function saveasRAW(){
		$this->saveRAW($this->input->post('saveas_name'));
	}
	public function CSVDownload(){
		$uuid = $this->input->post('uuid');
		$file = $this->input->post('file');
		//conv the \n to \r\n at EOL for fitting the NOTEPAD in windows
		$CSV = $this->Txtsim_model->spice_result_to_CSV($uuid, $file);
		$name = 'data.csv';
		force_download($name, $CSV);
	}
	
	public function saveNetlist($filename = 'netlist'){
		$a['netlist'] = $this->input->post('netlist');
		$a['analyses'] = $this->input->post('analyses');
		$a['source'] = $this->input->post('source');
		$a['outvar'] = $this->input->post('outvar');

		//conv the \n to \r\n at EOL for fitting the NOTEPAD in windows
		$netlist =json_encode($a,JSON_NUMERIC_CHECK);
		force_download($filename . '.isp', $netlist);
	}
	
	public function saveasNetlist() {
		if(($filename = $this->input->post('saveas_name')) != '')
			$this->saveNetlist($filename);
		else
			$this->saveNetlist();
	}
	
	public function loadNetlist(){
		$config['upload_path'] = './uploads/txtsim';
		$config['allowed_types'] = 'isp';
		$this->load->library('upload',$config);
		$uploader = $this->upload->do_upload("Netlistupload");
		$data = $this->upload->data();
		$string = read_file($data['full_path']);
		//echo $this->upload->display_errors('<p>', '</p>');
		//var_dump($data); 
		
		if ($string && $this->upload->file_ext ===".isp"){
			echo json_encode(array_merge(array("error" => false, "type"=> $this->upload->file_ext, "netlist"=>$string)),JSON_NUMERIC_CHECK);
		}else{
			echo json_encode(array_merge(array("error" => true)),JSON_NUMERIC_CHECK);
		}
	}
	public function savePNG(){
		$png = $this->input->post('png');
		$filename = $this->input->post('filename');
		$filename = preg_replace("/[\\/:\"*?<>;\|]/", "_", $filename);
		if(!$filename)
			$filename = "plot";
		$pieces = explode(",",$png);
		$data = base64_decode($pieces[1]);
		$im = imagecreatefromstring($data);
		imagealphablending($im, false);
		imagesavealpha($im, true);
		if ($im !== false) {
			//change background to white
			$width = imagesx($im);
			$height = imagesy($im);
			$bg = imagecreatetruecolor($width, $height);
			$white = imagecolorallocate($bg, 255, 255, 255);
			imagefill($bg, 0, 0, $white);			
			imagecopyresampled(
			$bg, $im,
			0, 0, 0, 0,
			$width, $height,
			$width, $height);
			
			//force download
			header('Content-type: octet/stream');
			header('Content-disposition: attachment; filename=' . $filename . '.png;');
			imagepng($bg);
			imagedestroy($im);
			imagedestroy($bg);
		}
	}
	
// 	public function savePNGfromVML(){
// 		return;
// 		$uuid = uniqid('v2p.', true);
// 		$path["vml"] = dirname(__FILE__) . "/../vmltopng/";
// 		$path["lib"] = dirname(__FILE__) . "/../third_party/VectorConverter1.2/";
// 		$vml = $this->input->post('png'); 
// 		//return;
// 		exec("rm " . $path["vml"] . "* -r");
// 		if(mkdir($path["vml"] . $uuid))
// 		{
			/*$templatehead = '<?xml version="1.0"?><?xml-stylesheet type="text/xsl" href="../vml2svg.xsl"?><HTML xmlns:v = "urn:schemas-microsoft-com:vml" xmlns="http://www.w3.org/1999/xhtml"><meta http-equiv="content-type" content="text/html;charset=iso-8859-1"><HEAD><TITLE>Rect</TITLE><META http-equiv="Content-Type" content="text/html; charset=windows-1252" /><OBJECT id="VMLRender" classid="CLSID:10072CEC-8CC1-11D1-986E-00A0C955B42E"></OBJECT><STYLE>v\:* { BEHAVIOR: url(#VMLRender) }</STYLE></HEAD><BODY>';
			$templatefooter = '</BODY><meta http-equiv="content-type" content="text/html;charset=iso-8859-1"></HTML>';
			$templatehead = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"><html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml"><head><title>VML</title><?import namespace="v" implementation="#default#VML" ?><style> v/:rect,v/:rect,v/:imagedata { display:inline-block } </style></head><body>';
			$templatefooter = '</body></html>';*/
// 			$vmlfile = fopen($path["vml"] . $uuid . "/vml", "w");
// 			fwrite($vmlfile, $templatehead . $vml . $templatefooter);
// 			fclose($vmlfile);
// 			//return;
// 			$arg = array(
// 				"cd",
// 				"\"" . $path["vml"] . $uuid . "/" . "\"",
// 				"&&",
// 				"/opt/php/bin/php",
// 				"\"" . $path["lib"] . "vc.php" . "\"",
// 				"-gif",
// 				"\"" . $path["vml"] . $uuid . "/vml" . "\"",
// 				"\"" . $path["vml"] . $uuid . "/gif" . "\""
// 			);
// 			exec(implode(" ", $arg), $output, $result);
// 			
// 			$txt = file_get_contents($path["vml"] . $uuid . "/temp.html");
// 			$txt = str_replace("xxx:", "", $txt);
// 			$fs = fopen($path["vml"] . $uuid . "/temp.html", "w");
// 			fwrite($fs, $txt);
// 			fclose($fs);
// 		}
// 	}
}
$count1=0;
/* End of file txtsim.php */
/* Location: ./application/controllers/txtsim.php */
