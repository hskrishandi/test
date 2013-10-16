<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class simulation extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->library(array('jsonRPCServer'));
		$this->load->helper(array('template_inheritance', 'html', 'credits', 'form', 'url', 'download'));
		$this->load->model(array('Simulation_model','Account_model', 'Discussion_model', 'Ngspice_model'));
		$this->config->load('simulation');		
	}
	
	public function index()
	{
		$user_info = $this->Account_model->isLogin();
		$data = array(
			'models' => ($user_info ? $this->Simulation_model->getModelLibrary($user_info->id) : array()), 
			'model_list' => $this->Simulation_model->getModels()
		);
		
		$this->load->view('simulation/simulation.php', $data);
	}

	public function ngspice()
	{		
		$this->jsonrpcserver->handle($this->Ngspice_model);
	}
	
	public function model($id)
	{
		if (!$this->Account_model->isAuth()) return;
		
		$model_info = $this->Simulation_model->getModelInfoById($id);
		$model_bias = $this->Simulation_model->getModelBias($id);
		$model_params = $this->Simulation_model->getModelParams($id);
		$model_outputs = $this->Simulation_model->getModelOutputs($id);
		
		if ($model_info == null) {
			redirect(base_url('simulation'));
			return;
		}
		
		$post_id = $model_info->post_id;
		$user_info = $this->Account_model->isLogin();
		$data = array(		
			'models' => $this->Simulation_model->getModelLibrary($user_info->id, $id),
			'backend_url' => $this->config->item('backend_url'),
			'model_id' => $id,
			'model_name' => $model_info->name,
			'bias' => $model_bias,
			'params' => $model_params,
			'outputs' => $model_outputs,
			'comment_data' => array(
				'model_name' => $model_info->name,
				'posts' => $this->Discussion_model->getPosts($post_id),
				'reply' => $this->Discussion_model->getReply($post_id),
				'countComment' => $this->Discussion_model->getCountCommentById($post_id),
				'userInfo' => $user_info
			)			
		);
		
		$this->load->view('simulation/' . $model_info->name . '.php', $data);
	}
		
	public function download()
	{
		if (!$this->Account_model->isAuth()) return;
		if (!$this->input->post()) {
			redirect(base_url());
		}
		$params = $this->input->post(null, true);
		$output = "";
		foreach ($params as $key => $value) {
			$output .= $key."=".$value." ";
		}
		$output = trim($output);

		force_download('params.ipa', $output);
	}
	
	public function upload()
	{
		if (!$this->Account_model->islogin()) {
			echo json_encode(array(
				'success' => false,
				'result' => "Unauthorized Access. Please login to access the service."
			));
			return;
		}
		
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'ipa';
		$config['max_size']	= '1024';

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload("paramFile")) {
			echo json_encode(array(
				'success' => false,
				'result' => $this->upload->display_errors()
			));
		} else {
			$data = $this->upload->data();
			$params = array();
			
			preg_match_all ('/[^=\+\s]+\s*=\s*[^\s]+/' ,addslashes(file_get_contents($data["full_path"])), $fields);
			
			foreach ($fields[0] as $entry) {
				$map = explode('=', $entry, 2);
				$map[0] = strtolower(trim($map[0]));
				$map[1] = trim($map[1]);
				if (count($map) < 2 || !is_numeric($map[1])) continue;
				$params[$map[0]] = $map[1];
			}
			
			if (count($params) > 0) {
				echo json_encode(array(
					'success' => true,
					'result' => $params
				));
			} else {
				echo json_encode(array(
					'success' => false,
					'result' => "The file you have just uploaded is invalid. Please check the file format and try again."
				));
			}
			
			@unlink($data["full_path"]);
		}
	}
	
	public function model_library($method)
	{
		$user_info = $this->Account_model->isLogin();		
		
		$success = false;
		$result = "Bad Request.";		
		$params = $this->input->post(null, true);
				
		switch ($method) {
		case 'new':			
			if (!$user_info) {
				redirect(base_url('simulation'));
			}
			$this->Simulation_model->newModelLibrary($user_info->id);
			break;
		case 'download':
			if (!$user_info) {
				redirect(base_url('simulation'));
			}
			$output = $this->Simulation_model->getModelLibraryData($user_info->id);
			force_download('library.iml', json_encode($output));
			return;
		case 'upload':
			if (!$user_info) {
				echo json_encode(array(
					'success' => false,
					'result' => "Unauthorized Access. Please login to access the service."
				));
				return;
			}
			
			$config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'iml';
			$config['max_size']	= '1024';
			$this->load->library('upload', $config);

			if (!$this->upload->do_upload("paramModelLibrary")) {
				echo json_encode(array(
					'success' => false,
					'result' => $this->upload->display_errors()
				));
			} else {
				$data = $this->upload->data();
				$data_array = json_decode(file_get_contents($data["full_path"]), true);

				if ($data_array) {
					$this->Simulation_model->newModelLibrary($user_info->id);				
					echo json_encode(array(
						'success' => true,
						'result' => $this->Simulation_model->loadModelLibrary($user_info->id, $data_array)
					));
				} else {
					echo json_encode(array(
						'success' => false,
						'result' => "The file you have just uploaded is invalid. Please check the file format and try again."
					));
				}
			
				@unlink($data["full_path"]);
			}
			return;
		}

		redirect(base_url('simulation'));
	}
	
	public function user_param_set($method, $model_id)
	{
		$user_info = $this->Account_model->isLogin();		
		if (!$user_info) {
			echo json_encode(array(
				'success' => false,
				'result' => "Unauthorized Access. Please login to access the service."
			));
			return;
		}
		
		$success = false;
		$result = "Bad Request.";		
		$params = $this->input->post(null, true);
		
		switch ($method) {
		case 'list':
			$result = $this->Simulation_model->getParamSets($user_info->id, $model_id);
			$success = true;	
			break;
		case 'get':		
			if (!$params || !isset($params['id'])) break;
			$data = $this->Simulation_model->getParamSet($user_info->id, $model_id, $params['id']);
			if ($data == null) {
				$result = "Cannot load the requested parameter set.";
				break;
			}		
			$success = true;
			$result = json_decode($data);
			break;
		case 'add':
			if (!$params || !isset($params['name']) || !isset($params['data'])) break;
			if ($this->Simulation_model->getParamSetByName($user_info->id, $model_id, $params['name']) != null) {
				if (!$this->Simulation_model->updateParamSetByName($user_info->id, $model_id, $params['name'], $params['data'])) {
					$result = "Cannot save the parameter set. Please try again";
					break;
				}		
				$success = true;
				$result = "";
				break;
			}
			$id = $this->Simulation_model->addParamSet($user_info->id, $model_id, $params['name'], $params['data']);
			if ($id < 0) {
				$result = "Cannot save the parameter set. Please try again";
				break;
			}		
			$success = true;
			$result = $id;
			break;
/*		case 'set':
			if (!$params || !isset($params['id']) || !isset($params['data'])) break;
			if (!$this->Simulation_model->updateParamSet($user_info->id, $model_id, $params['id'], $params['data'])) {
				$result = "Cannot save the parameter set. Please try again";
				break;
			}		
			$success = true;
			$result = "";
			break; */
		case 'del':
			if (!$params || !isset($params['id'])) break;
			if (!$this->Simulation_model->deleteParamSet($user_info->id, $model_id, $params['id'])) {
				$result = "Cannot delete the parameter set. Please try again";
				break;
			}		
			$success = true;
			$result = "";
			break;
		}
		
		echo json_encode(array(
			'success' => $success,
			'result' => $result
		));
	}
	
	public function param_set($method, $model_id)
	{
		if (!$this->Account_model->isLogin()) {
			echo json_encode(array(
				'success' => false,
				'result' => "Unauthorized Access. Please login to access the service."
			));
			return;
		}
		
		$success = false;
		$result = "Bad Request.";		
		$params = $this->input->post(null, true);
		
		switch ($method) {
		case 'list':
			$result = $this->Simulation_model->getDefaultParamSets($model_id);
			$success = true;	
			break;
		case 'get':		
			if (!$params || !isset($params['id'])) break;
			$data = $this->Simulation_model->getDefaultParamSet($model_id, $params['id']);
			if ($data == null) {
				$result = "Cannot load the requested parameter set.";
				break;
			}		
			$success = true;
			$result = json_decode($data);
			break;
		}
		
		echo json_encode(array(
			'success' => $success,
			'result' => $result
		));
	}
		
	private function getcsv($input, $delimiter=',', $enclosure='"', $escape=null, $eol=null) { 
		$temp=fopen("php://memory", "rw"); 
		fwrite($temp, $input); 
		fseek($temp, 0); 
		$r = array(); 
		while (($data = fgetcsv($temp, 4096, $delimiter, $enclosure)) !== false) { 
		$r[] = $data; 
		} 
		fclose($temp); 
		return $r; 
	} 
		
	public function downloadData()
	{
		if (!$this->Account_model->isAuth()) return;
		if (!$this->input->post()) {
			redirect(base_url());
		}
		$data = $this->input->post(null, true);
		$output = "";
		foreach ($data as $point) {
			$output .= floatval($point[0]) . ", " . floatval($point[1]) . "\r\n";
		}
		$output = trim($output);
		
		force_download('data.csv', $output);
	}
	
	public function uploadData()
	{
		if (!$this->Account_model->islogin()) {
			echo json_encode(array(
				'success' => false,
				'result' => "Unauthorized Access. Please login to access the service."
			));
			return;
		}
		
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'csv';
		$config['max_size']	= '1024';

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload("userdataFile")) {
			echo json_encode(array(
				'success' => false,
				'result' => $this->upload->display_errors()
			));
		} else {
			$data = $this->upload->data();
			$content = $this->getcsv(file_get_contents($data["full_path"]));
			$success = count($content) > 0;
			
			foreach ($content as $i => $entry) {
				if (!is_array($entry) || count($entry) != 2) {
					$success = false;
				}
				for ($j = 0; $j < 2; ++$j) {
					$content[$i][$j] = floatval($content[$i][$j]);
				}
			}
			
			if ($success) {
				echo json_encode(array(
					'success' => true,
					'result' => $content
				));
			} else {
				echo json_encode(array(
					'success' => false,
					'result' => "The csv file you have just uploaded is invalid. Please check the file format and try again."
				));
			}
			
			@unlink($data["full_path"]);
		}
	}

    public function csv($token, $column) {
        if (!$this->Account_model->isAuth()) return;
		if (!$this->input->post()) {
			redirect(base_url());
		}

        $data = $this->Ngspice_model->get_output($token, $output_id);
		$output = "";
		foreach ($data as $point) {
			$output .= floatval($point[0]) . ", " . floatval($point[1]) . "\r\n";
		}
		$output = trim($output);
		
		force_download('data.csv', $output);
    }
}

/* End of file simulation.php */
/* Location: ./application/controllers/simulation.php */
