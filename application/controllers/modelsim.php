<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class modelsim extends CI_Controller {
	private $uploadConfig;

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('template_inheritance', 'html', 'credits', 'form', 'url', 'download'));
		$this->load->model(array('Modelsim_model', 'Account_model', 'Discussion_model', 'Ngspice_model'));
		$this->load->library('parser');
		$this->config->load('simulation');	
		
		$this->uploadConfig = array(
			'upload_path' => './uploads/',
			'allowed_types' => 'ipa|iml|csv',
			'max_size' => '1024'
		);
	}
	
	public function index()
	{
		$user_info = $this->Account_model->isLogin();
		$data = array(
			'models' => ($user_info ? $this->Modelsim_model->getModelLibrary($user_info->id) : array()), 
			'model_list' => $this->Modelsim_model->getModelsInfo()
		);
		
		$this->load->view('simulation/model_list.php', $data);
	}

	public function model($id)
	{
		if (!$this->Account_model->isAuth()) return;
        
        $model_info = $this->Modelsim_model->getModelInfoById($id);
        if ($model_info == null) {
			redirect(base_url('modelsim'));
			return;
		}
		
		$post_id = $model_info->post_id;
		$user_info = $this->Account_model->isLogin();
		$data = array(		
			'model_info' => $model_info,
			'comment_data' => array(
				'model_name' => $model_info->name,
				'posts' => $this->Discussion_model->getPosts('undelete',$post_id),
				'reply' => $this->Discussion_model->getReply($post_id),
				'countComment' => $this->Discussion_model->getCountModelCommentById($post_id),
				'userInfo' => $user_info
			)			
		);
				
		$this->load->view('simulation/model.php', $data);
	}
	
    public function modelLibrary($method, $id = 0) 
    {
        $user_info = $this->Account_model->isLogin();
        $response = null;

        if ($user_info) {
			switch ($method) {
			case "GET":
				if ($id == 0) {
					$models = $this->Modelsim_model->getModelLibrary($user_info->id);
					$response = array();

					foreach ($models as $model) {
						if (!array_key_exists($model->model_name, $response)) {
							$response[$model->model_name] = array(
								'id' => $model->model_id,
								'name' => $model->model_name,
								'library' => array()
							);
						}
						$response[$model->model_name]['library'][] = array('id' => $model->id, 'name' => $model->name);
					}
			
					$response_array = array();
					foreach ($response as $item) {
						$response_array[] = $item;
					}
					$response = $response_array;
				} else {
					$response = $this->Modelsim_model->getModelLibraryEntry($user_info->id, $id);
				}
				break;
			case "DELETE":
				$response = $this->Modelsim_model->deleteModelLibraryEntry($user_info->id, $id);
				break;
			case "ADD":
				if (!$this->input->post()) {
					$this->output->set_status_header('405');
				} else {
					$name = $this->input->post('name', true);
					$modelID = $this->input->post('modelID', true);
					$params = $this->input->post('params', true);
			
					if (!$modelID || !$name || !is_array($params)) {
						$this->output->set_status_header('400');
					} else {
						$response = $this->Modelsim_model->addModelLibraryEntry($user_info->id, $modelID, $name, json_encode($params));
					}
				}
				break;
			case "DOWNLOAD":
				$output = $this->Modelsim_model->getModelLibrary($user_info->id);
				force_download('library.iml', json_encode($output));
				break;
			case "DOWNLOADAS":
				$output = $this->Modelsim_model->getModelLibrary($user_info->id);
				$data = json_decode($this->input->post('data'), true);
				force_download($data['saveas_name'] . '.iml', json_encode($output));
				break;
			case "UPLOAD":			
				$this->load->library('upload', $this->uploadConfig);
				
				if (!$this->upload->do_upload("file")) {
					$response = array('success' => false, 'error' => $this->upload->display_errors());
				} else {
					$data = $this->upload->data();
					$data_array = json_decode(file_get_contents($data["full_path"]), true);

					// assume correct format
					if ($data_array) {
						$this->Modelsim_model->newModelLibrary($user_info->id);				
						$response = array(
							'success' => true,
							'data' => $this->Modelsim_model->loadModelLibrary($user_info->id, $data_array)
						);
					} else {
						$response = array(
							'success' => false,
							'error' => "The file you have just uploaded is invalid. Please check the file format and try again."
						);
					}
				}
				
				@unlink($data["full_path"]);
				break;
			case 'NEW':			
				$this->Modelsim_model->newModelLibrary($user_info->id);	
				$response = array('success' => true);
				break;
			default:
				$this->output->set_status_header('404');
			}
		} else {
            $this->output->set_status_header('401');
        }

        $this->outputJSON($response);
    }

    public function paramSet($method, $model_id, $set_id = 0)
	{
        $response = null;
		if ($this->Account_model->isLogin()) {
			switch ($method) {
			case "GET":
				if ($set_id == 0) {
					$response = $this->Modelsim_model->getParamSets($model_id);
				} else {
					$response = json_decode($this->Modelsim_model->getParamSet($model_id, $set_id));
				}
				break;
			default:
				$this->output->set_status_header('404');
			}
        } else {
            $this->output->set_status_header('401');
        }

        $this->outputJSON($response);
	}

    public function clientParamSet($method, $modelID = 0)
	{
        $response = array('success' => false, 'error' => 'error');
		if ($this->Account_model->isLogin()) {
			switch ($method) {
			case "DOWNLOAD":
			case "DOWNLOADAS":
				$params = $this->input->post('data', true);
				if (!$params) {
					$this->output->set_status_header('400');
					$response = array('success' => false, 'error' => "Invalid input.");
				} else {
					$filename = ($modelID ? 'model' . $modelID : 'params');
							
					$params = json_decode($params);
					$output = $params;
					
					$output = "";
					foreach ($params as $param) {
						if(isset($param->filename))
							$filename = $param->filename;
						else
							$output .= $param->name."=".$param->value." ";
					}
					
					$output = trim($output);

					force_download($filename . '.ipa', $output);
					return;
				}				
				break;
			case "UPLOAD":
				$this->load->library('upload', $this->uploadConfig);

				if (!$this->upload->do_upload("file")) {
					$response = array('success' => false, 'error' => $this->upload->display_errors());
				} else {
					$data = $this->upload->data();
					$params = array();
					
					preg_match_all ('/[^=\+\s]+\s*=\s*[^\s]+/' ,addslashes(file_get_contents($data["full_path"])), $fields);
					
					foreach ($fields[0] as $entry) {
						$map = explode('=', $entry, 2);
						$map[0] = strtolower(trim($map[0]));
						$map[1] = trim($map[1]);
						if (count($map) < 2 || !is_numeric($map[1])) continue;
						$params[] = array("name" => $map[0], "value" => $map[1]);
					}
					
					if (count($params) > 0) {
						$response = array('success' => true, 'data' => $params);
					} else {
						$response = array('success' => false, 'error' => "Invalid file.");
					}
			
					@unlink($data["full_path"]);
				}
				break;
			default:
				$this->output->set_status_header('404');
			}
        } else {
            $this->output->set_status_header('401');
        }

        $this->outputJSON($response);
	}
	
	public function clientPlotData($method)
	{
        $response = array('success' => false, 'error' => 'error');
		if ($this->Account_model->isLogin()) {
			switch ($method) {
			case "DOWNLOAD":
			case "DOWNLOADAS":
				$filename = "data";
				$data = $this->input->post('data', true);
				if (!$data) {
					$this->output->set_status_header('400');
					$response = array('success' => false, 'error' => "Invalid input.");
				} else {
					$data = json_decode($data);
					if(isset($data->saveas_name))
						$filename = $data->saveas_name;
					$data = $data->data;
					$output = "";
					foreach ($data as $plot) {
						foreach ($plot as $point) {
							$output .= floatval($point[0]) . ", " . floatval($point[1]) . "\r\n";
						}
					}
					$output = trim($output);
		
					force_download($filename . ".csv", $output);
					return;
				}				
				break;
			case "UPLOAD":
				$this->load->library('upload', $this->uploadConfig);

				if (!$this->upload->do_upload("file")) {
					$response = array('success' => false, 'error' => $this->upload->display_errors());
				} else {
					$data = $this->upload->data();
					$content = $this->getcsv(file_get_contents($data["full_path"]));
					$success = count($content) > 0;
					$result = array();
					
					if ($success) {
						$plot = 0;
						foreach ($content as $i => $point) {
							if (!is_array($point) || count($point) != 2) {
								$success = false;
								break;
							}
							if (empty($result) || $point[0] == $startx) {
								// first point
								$startx = $point[0];
								$result[++$plot] = array();
							}
							$result[$plot][] = array(floatval($point[0]), floatval($point[1]));
						}
					}
					
					if ($success) {
						$response = array('success' => true, 'data' => array_values($result));
					} else {
						$response = array('success' => false, 'error' => 'Invalid format');
					}
			
					@unlink($data["full_path"]);
				}
				break;
			default:
				$this->output->set_status_header('404');
			}
        } else {
            $this->output->set_status_header('401');
        }

        $this->outputJSON($response);
	}
	
	public function modelDetails($model_id)
	{
		$response = null;
		if ($this->Account_model->isLogin()) {
            $response = array(
				'biases' => $this->Modelsim_model->getModelBiases($model_id),
				'params' => $this->Modelsim_model->getModelParams($model_id),
				'outputs' => $this->Modelsim_model->getModelOutputs($model_id)
			);
        } else {
            $this->output->set_status_header('401');
        }

        $this->outputJSON($response);
	}
	
	public function simulate()
	{		
		$response = null;
		
		if (!$this->Account_model->isLogin()) {
            $this->output->set_status_header('401');
        } else if (!$this->input->post()) {
			$this->output->set_status_header('405');
		} else {
			$modelID = $this->input->post('modelID', true);
			$biases = $this->input->post('biases', true);
			$params = $this->input->post('params', true);
			
			if (!$modelID || !is_array($biases) || !is_array($params) 
					|| !is_array($biases["variable"])) {
				$this->output->set_status_header('400');
			} else {
				//To prevent user wrongly type step = 0 or < 0.00001 which make server overload
				foreach($biases["variable"] as $vars)
					if(!is_numeric($vars["step"]) || $vars["step"] == 0 || abs($vars["step"]) < 0.00001)
					{
						$this->output->set_status_header('400');
						return;
					}
				$vars["step"] = abs($vars["step"]);
				
				if (!isset($biases["fixed"])) {
					$biases["fixed"] = array();
				}
				if (!isset($params["model"])) {
					$params["model"] = array();
				}
				if (!isset($params["instance"])) {
					$params["instance"] = array();
				}
				
				foreach (array("model", "instance") as $arr) {
					foreach($params[$arr] as $key => $param) {
						if (!isset($param["value"]) || trim($param["value"]) == '') {
							unset($params[$arr][$key]);
						}
					}
				}
				
				// Valid input format
				$netlist = $this->getNetlist($modelID, $biases, $params);
				if ($netlist != null) {
					$response = $this->Ngspice_model->simulate($netlist);
				}
			}
		}		

        $this->outputJSON($response);
	}
	
        public function simulationStatus()
        {
                if (!$this->Account_model->isLogin())
                        $this->output->set_status_header('401');
                else if (!$this->input->post())
                        $this->output->set_status_header('405');
                else
                {
                        $uuid = $this->input->post('session', true);
                        $response = $this->Ngspice_model->spiceStatus($uuid);
                        $this->outputJSON($response);
                }
        }

        public function simulationStop()
        {
                if (!$this->Account_model->isLogin())
                        $this->output->set_status_header('401');
                else if (!$this->input->post())
                        $this->output->set_status_header('405');
                else
                {
                        $uuid = $this->input->post('session', true);
                        $response = $this->Ngspice_model->spiceStop($uuid);
                }
        }

	
	public function getData($token, $column_id)
	{
		$response = null;
		
		if (!$this->Account_model->isLogin()) {
            $this->output->set_status_header('401');
		} else {
			$response = $this->Ngspice_model->getData($token, $column_id);
			if (empty($response)) {
				$this->output->set_status_header('404');
			}
		}
		
		$this->outputJSON($response);
	}
	
	private function getNetlist($modelID, $biases, $params)
	{
		$model_info = $this->Modelsim_model->getModelInfoById($modelID);
		if ($model_info == null) return null;
		
		$input = array();
		$input["prefix"] = $model_info->prefix;
		$input["suffix"] = $model_info->suffix;
		$input["mname"] = $input["type"] = $model_info->type;
		$input["iname"] = substr($model_info->name, 0, 7 - strlen($input["suffix"]));	// instance name is atmost 8 characters with prefix, eg. MXXXXXXXX
		
		$model_biases = $this->Modelsim_model->getModelBiases($modelID);
		$fixed_params = $this->Modelsim_model->getModelParams($modelID, false);
		$model_outputs = $this->Modelsim_model->getModelOutputs($modelID);
		
		$outputs = ' ';
		foreach ($model_outputs as $output) {
			$outputs .= $this->parser->parse_string($output->variable, $input, true) . ' ';
		}
		$input['outputs'] = $outputs;
		$input['iparams'] = $params["instance"];
		$input['mparams'] = $params["model"];
		$input['varsources'] = $biases["variable"];
		
		foreach ($fixed_params["instance"] as $param) {
			$input['iparams'][] = array("name" => $param->name, "value" => $param->default);
		}
		
		foreach ($fixed_params["model"] as $param) {
			$input['mparams'][] = array("name" => $param->name, "value" => $param->default);
		}
		
		$input['sources'] = array();
		foreach ($model_biases as $bias) {
			$input['sources'][] = array("name" => $bias->name, "value" => $bias->default);
		}
		foreach ($biases["fixed"] as $b2) {
			foreach ($input['sources'] as $key => $bias) {
				if ($b2["name"] == $bias["name"]) {
					$input['sources'][$key]["value"] = $b2["value"];
					break;
				}
			}
		}
		
		return $this->Ngspice_model->getNetlistForModelSim($input);
	}

    private function outputJSON($output)
    {
        //$this->output->set_header('Content-Type: application/json; charset=utf-8');
        //$this->output->set_output(json_encode($output));
       	echo json_encode($output);
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
}

/* End of file simulation.php */
/* Location: ./application/controllers/simulation.php */
