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
	
	public function checkSaved()
	{
		if (!$this->Account_model->isAuth()) return;
		$user_info = $this->Account_model->isLogin();
		$USER_ID = $user_info->id;
		if (file_exists('./uploads/developer_models/unfinished/'.$USER_ID)){
			$data = array('hasSavedData' => true);
			echo json_encode($data);
		}
		else{
			$data = array('hasSavedData' => false);
			echo json_encode($data);
		}
	}
	
	public function modelsInProgressInfo()
	{
		$models_in_progress_info = $this->Developer_model->getModelsInProgress();
		$this->outputJSON($models_in_progress_info);
	}
	
	public function loadSavedModelInfo($user_id)
	{
		if (!$this->Account_model->isAuth()) return;
		$user_info = $this->Account_model->isLogin();
		$USER_ID = $user_info->id;
		$data = read_file('uploads/developer_models/unfinished/'.$USER_ID.'/form_data.dat');
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
	
	public function tos()
	{
		if ($this->input->post()) {
			if ($this->input->post('response') === "I Agree") {
				//$this->session->set_flashdata('developer_tos', 1);
				//redirect('developer');
				redirect('developer/fill_form');
			} else {
				redirect('');
			}
		}
		
		$this->load->view('developer/tos');
	}
	/*
	public function delete($filename)
	{
		delete_files('./uploads/developer_models'.$filename, TRUE);
		rmdir('./uploads/developer_models'.$filename);
	}
	*/
	
	
	public function deleteSavedData()
	{
		if(!$this->Account_model->isAuth()) return;
		$user_info = $this->Account_model->isLogin();
		$USER_ID = $user_info->id;
		delete_files('./uploads/developer_models/unfinished/'.$USER_ID, TRUE);
		if(file_exists('./uploads/developer_models/unfinished/'.$USER_ID))
			rmdir('./uploads/developer_models/unfinished/'.$USER_ID);
	}
	
	public function fill_form()
	{
		$this->load->view('developer/form');
	}
	
	public function submit($step)
	{
		if (!$this->Account_model->isAuth()) return;
		$user_info = $this->Account_model->isLogin();
		$USER_ID = $user_info->id;
		$data=NULL;
		$form = $this->config->item('developer_form');
		$this->form_validation->set_rules($form['text_rule'][$step]);
		$this->form_validation->set_error_delimiters('', '');
		//set file validation
		foreach($form['file_rule'][$step] as $element){
			if ($_FILES[$element['field']]["error"] == 4 && !$_POST[$element['field']])
			{
				$this->form_validation->set_rules($element['field'], 'file', 'required');
			}
		}
		$data_valid = true;
		if($step != 'step4')
			$data_valid = $this->form_validation->run();
		$response = array();
		if ($data_valid){
			if (!file_exists('./uploads/developer_models/unfinished/'.$USER_ID)) mkdir('./uploads/developer_models/unfinished/'.$USER_ID);
			$allowTypeConstant = array(
				'structure' => 'pdf|jpg|png',
				'model_code' => 'zip|tar',
				'parameter_list' => 'csv|xls|xlsx',
				'output_list' => 'txt|csv|xls|xlsx',
				'default' => 'ipa|iml|csv|pm|txt|pdf|doc|jpg'
			);
			$uploadConfig = array(
				'upload_path' => './uploads/developer_models/unfinished/'.$USER_ID,
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
							$response['error_info'][$fieldname] = $errors;
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
				$data['create_time'] = date("jS F Y h:i:s A");
				$data['user_id'] = $USER_ID;
			}
			if($response['success'])
			{
				write_file('./uploads/developer_models/unfinished/'.$USER_ID.'/form_data.dat', $formData, 'w+');
				/*$lastestUploadDate = "Last update time: ".date("jS F Y h:i:s A")."\nStatus: Successful uploaded.\n";
				write_file('./uploads/developer_models/unfinished/'.$USER_ID.'/log.txt', $lastestUploadDate, 'a');*/
				//add a new entry to db
				if($step === 'step4' && isset($data))
				{
					$this->Developer_model->addNewModelToDb($data);
					if (!file_exists('./uploads/developer_models/finished')) mkdir('./uploads/developer_models/finished');
					$foldername = './uploads/developer_models/finished/'.$USER_ID;
					$x = 1;
					while(file_exists($foldername.'#'.$x)) $x++;
					rename('./uploads/developer_models/unfinished/'.$USER_ID,$foldername.'#'.$x);
					$this->submit_done();
				}
				//move the data to finished folder
				
			}
			else
			{
				/*$lastestUploadDate = "Last update time: ".date("jS \of F Y h:i:s A")."\nStatus: Incomplete.\n";
				write_file('./uploads/developer_models/unfinished/'.$USER_ID.'/log.txt', $lastestUploadDate, 'a');*/
			}
			$this->outputJSON($response);
			if(!$this->input->is_ajax_request())
				redirect('developer/');
		}
		else
		{
			$data = NULL;
			$response['error_info'] = array();
			foreach($form['text_rule'][$step] as $element){
				$response['error_info'][$element['field']]= form_error($element['field']);
			}
			$response["success"] = false;
			$this->outputJSON($response);
			if(!$this->input->is_ajax_request())
				redirect('developer/');
		}
	}
	
	public function submit_done()
	{
		if (!$this->Account_model->isAuth()) return;
		$user_info = $this->Account_model->isLogin();
		$config['mailtype']='html';
		$this->email->initialize($config);
		$this->email->from("model@i-mos.org", 'i-MOS Team');
		$this->email->to($user_info->email);
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
