<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class developer extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->helper(array('template_inheritance', 'html', 'form', 'url','file'));
		//$this->load->driver('session');
		$this->load->model(array('Developer_model','Account_model'));
		$this->load->library('session');
		$this->load->library('MY_Session');
		$this->load->library('form_validation');
		$this->load->library('email');
		$this->config->load('developer_form');
	}

	public function index()
	{
    if (!$this->Account_model->isAuth()) return;
		if (!$this->session->flashdata('developer_tos')) {
			redirect('developer/progress');
		}

		$this->load->view('developer/message');
	}

	public function progress()
	{
		if (!$this->Account_model->isAuth()) return;
		$this->load->view('developer/progress');
	}

	public function modelsInProgressInfo()
	{
		$models_in_progress_info = $this->Developer_model->getModelsInProgress();
		$this->outputJSON($models_in_progress_info);
	}

	public function loadSavedModelInfo($model_id)
	{
		if (!$this->Account_model->isAuth()) return;
		$user_info = $this->Account_model->isLogin();
		$USER_ID = $user_info->id;

		$data = read_file('uploads/developer_models/unfinished/'.$model_id.'@'.$USER_ID.'/form_data.dat');
		$fieldname = NULL;
		$value = NULL;
		if (preg_match_all ('/\s*(\w*)\s*:\s*(.*)\s*\n/', $data, $fields)) {
			$fieldname = $fields[1];
			$value = $fields[2];
		}
		$output = array(
			'fieldname' => $fieldname,
			'value' => $value
		);
		$this->outputJSON($output);
	}

	public function user_models()
	{
		if (!$this->Account_model->isAuth()) return;
        /**
         * Under Construction
         * by leon 20160508
         */
        // $this->load->view('developer/user_models');
		$this->load->view('developer/501');
	}

	public function loadUserModelList()
	{
		if (!$this->Account_model->isAuth()) return;
		$user_info = $this->Account_model->isLogin();
		$USER_ID = $user_info->id;
		$models_info = $this->Developer_model->getUserModelList($USER_ID);
		$this->outputJSON($models_info);
	}

	public function tos()
	{
		if (!$this->Account_model->isAuth()) return;
		$model_id = urldecode($this->input->get('model_id'));
		if ($this->input->post()) {
			if ($this->input->post('response') === "I Agree") {
				//$this->session->set_flashdata('developer_tos', 1);
				//redirect('developer');
				redirect('developer/fill_form/'.$model_id);
			} else {
				redirect('');
			}
		}

        /**
         * Under Construction
         * by leon 20160508
         */
        $this->load->view('developer/tos');
		// $this->load->view('developer/501');
	}

	/*
	public function delete($filename)
	{
		delete_files('./uploads/developer_models'.$filename, TRUE);
		rmdir('./uploads/developer_models'.$filename);
	}
	*/

	public function deleteModel($model_id)
	{
		if(!$this->Account_model->isAuth()) return;
		$user_info = $this->Account_model->isLogin();
		$USER_ID = $user_info->id;
		$data['user_id'] = $USER_ID;
		$data['id'] = $model_id;
		$exist = $this->Developer_model->checkModelExistence($data);
		if($exist){
			delete_files('./uploads/developer_models/unfinished/'.$model_id.'@'.$USER_ID, TRUE);
			if(file_exists('./uploads/developer_models/unfinished/'.$model_id.'@'.$USER_ID))
				rmdir('./uploads/developer_models/unfinished/'.$model_id.'@'.$USER_ID);
			$this->Developer_model->deleteModel($data);
		}
	}

	public function fill_form($model_id)
	{
		if(!$this->Account_model->isAuth()) return;
		$data['model_id'] = $model_id;
		$this->load->view('developer/form');
	}

	public function submit($step)
	{
		$model_id = $_POST['model_id'];
		if(!is_numeric($model_id)) return;
		$model_id = (int)$model_id;
		if (!$this->Account_model->isAuth()) return;
		$user_info = $this->Account_model->isLogin();
		$USER_ID = $user_info->id;
		$data['user_id'] = $USER_ID;
		$data['id'] = $model_id;
		$exist = $this->Developer_model->checkModelExistence($data);
		if($model_id!=0 && !$exist){
			return;
		}
		$newModel = false;
		//allocate a new model_id
		if($model_id == 0)
		{
			$returnIDArray = $this->Developer_model->getNextModelID();
			if($returnIDArray)
				$newModelId = ++$returnIDArray[0]->id;
			else $newModelId = 1;
			$model_id = $newModelId;
			$newModel = true;
		}
		$data=NULL;
		$form = $this->config->item('developer_form');
		$data_valid = true;
		if($step == 'step4'){
			for($i =1; $i < 5;$i++)
			{
				$this->form_validation->set_rules($form['text_rule']['step'.$i]);
				$this->form_validation->set_error_delimiters('', '');
				//set file validation
				foreach($form['file_rule']['step'.$i] as $element){
					if ($_FILES[$element['field']]["error"] == 4 && !$_POST[$element['field']])
					{
						$this->form_validation->set_rules($element['field'], 'file', 'required');
					}
				}
			}
			$data_valid = $this->form_validation->run();
		}
		$uploadPath = './uploads/developer_models/unfinished/'.$model_id.'@'.$USER_ID;
		$response = array();
		if ($data_valid){
			if (!file_exists($uploadPath)) mkdir($uploadPath);
			$allowTypeConstant = array(
				'structure' => 'pdf|jpg|png',
				'model_code' => 'zip|tar',
				'parameter_list' => 'txt|csv|xls|xlsx',
				'output_list' => 'txt|csv|xls|xlsx',
				'default' => 'ipa|iml|csv|pm|txt|pdf|doc|jpg'
			);
			$uploadConfig = array(
				'upload_path' => $uploadPath,
				'allowed_types' => 'ipa|iml|csv|pm|txt|cpp',
				'max_size' => '1024',
				'overwrite' => true
			);
			$formData = '';
			$this->load->library('upload');
			if ($this->input->post()) {
				foreach($_POST as $fieldname => $val)
				{
					$temp = $this->input->post($fieldname);
					if($temp) $formData = $formData.$fieldname.' : '.$temp."\n";
				}
				foreach($_FILES as $fieldname => $fileObject)  //fieldname is the form field name
				{
					$isFileFieldInTheCurrentStep = false; //do not upload a step3's file in step 2's 'saved and continue'
					for ($x=1; $x<=$step[4]; $x++){
						foreach($form['file_rule']['step'.$x] as $element)
						{
							if($element['field'] === $fieldname)
							{
								$isFileFieldInTheCurrentStep = true;
							}
						}
					}
					if (!empty($fileObject['name']) && $isFileFieldInTheCurrentStep)
					{
						$uploadConfig['file_name'] = $fieldname;
						$uploadConfig['allowed_types'] = $allowTypeConstant[$fieldname];
						$this->upload->initialize($uploadConfig);
						if (!$this->upload->do_upload($fieldname))
						{
							$errors = $this->upload->display_errors('','');
							$response['error_info'][$step][$fieldname] = $errors;
							$response['success'] = false;
							//flashMsg($errors);
						}
						else{$formData = $formData.$fieldname.' : true'."\n";}
					}
				}
			}
			if(!isset($response['error_info'])) {
				$response['success'] = true;
				$data['user_name'] = $_POST['author_list'];
				$data['stage'] = 1;
				$data['model_name'] = $_POST['title'];
				$data['description'] = $_POST['description'];
				$data['last_update_time'] = date("Y-F-j g:i A");
				$data['user_id'] = $USER_ID;
				$data['complete'] = 0;
				$data['id'] = $model_id;
			}
			if($response['success'])
			{
				if($newModel)
				{
					$data['id'] = $model_id;
					if($step != 'step4'){
						$data['complete'] = 0;
					}
					$this->Developer_model->addNewModelToDb($data);
					write_file($uploadPath.'/form_data.dat', $formData, 'w+');
				}
				else{
					if($step != 'step4'){
						$this->Developer_model->updateModelInfo($data);
						write_file($uploadPath.'/form_data.dat', $formData, 'w+');
						/*$lastestUploadDate = "Last update time: ".date("jS F Y h:i:s A")."\nStatus: Successful uploaded.\n";*/
						//add a new entry to db
					}
					else
					{
						$data['complete'] = 1;
						$this->Developer_model->updateModelInfo($data);
						$foldername = './uploads/developer_models/finished/';
						rename($uploadPath,$foldername.$model_id.'@'.$USER_ID);
						$this->submit_done($_POST['contact']); //send email
					}
				}
			}
			else{}
			$response['model_id'] = $model_id;
			$this->outputJSON($response);
		}
		else
		{
			$data = NULL;
			$response['error_info'] = array();
			for($i =1; $i < 5;$i++)
			{
				foreach($form['text_rule']['step'.$i] as $element){
					$response['error_info']['step'.$i][$element['field']]= form_error($element['field']);
				}
			}
			$response["success"] = false;
			$this->outputJSON($response);
			//if(!$this->input->is_ajax_request())
				//redirect('developer/');
		}
	}

	public function submit_done($current_email)
	{
		if (!$this->Account_model->isAuth()) return;
		$user_info = $this->Account_model->isLogin();
		$config['mailtype']='html';
		$this->email->initialize($config);
		$this->email->from("model@i-mos.org", 'i-MOS Team');
		//$this->email->cc("model@i-mos.org");
		$receiver = array();
		$receiver[] = $user_info->email;
		if($current_email != $user_info->email){
			$receiver[] = $current_email;
		}
		$receiver[] = "model@i-mos.org";

		$this->email->to($receiver);
		$this->email->subject("[i-MOS]Model Submitted");
		$msg="Dear ".$user_info->first_name.' '.$user_info->last_name.'<br /> <br />Thank you for your interest in <i>i</i>-MOS. We have received your model code. Kindly, note that the processing period for the code is one month. Our i-MOS team will contact you after processing the code successfully.<br /><br />For more information, visit www.i-mos.org<br /><br />Regards,<br /><i>i</i>-MOS Team';
		$this->email->message($msg);
		$this->email->send();
	}

	public function download($foldername,$filename)
	{
		$this->load->helper('download');
		force_download($filename, file_get_contents('files/manual/'.$filename));
	}

	private function outputJSON($output)
	{
		echo json_encode($output);
	}

}

/* End of file developer.php */
/* Location: ./application/controllers/developer.php */
