<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class realcas extends REST_Controller {

    public function __construct()
    {
        parent::__construct();
        /**
         * Using Service-Repository pattern
         */
        $this->load->model('Services/Realcas_service');

        /**
         * Migrate from old realcas
         */
        $this->load->library(array('jsonRPCServer'));
        $this->load->helper(array('template_inheritance', 'html', 'credits', 'form', 'url', 'download', 'file'));
        $this->load->model(array('Account_model', 'Discussion_model', 'Txtsim_model', 'Simulation_model', 'Modelsim_model'));

        $this->uploadConfig = array(
            'upload_path' => './uploads/',
            'allowed_types' => 'ipa|iml|csv|pm|txt',
            'max_size' => '1024'
        );
    }

    public function index()
    {
        $this->requireAuth();
        $user_info = $this->getAuthUser();
        $this->load->view('realcas/index.php');
    }

    public function modelLibrary($method, $id = 0) 
    {
        $this->requireAuth();
        $user_info = $this->getAuthUser();
        $response = null;

        switch ($method) {
        case "GET":
            if ($id == 0) {
                $response = $this->Realcas_service->getModelLibrary($user_info->id);
            } else {
                $response = $this->Realcas_service->getModelLibrary($user_info->id, $id);
            }
            break;

        case "UPDATE":
            // Newly added for RealCAS function
            if (!$this->input->post()) {
                $this->output->set_status_header('405');
            } else {
                $id = $this->input->post('id', true);
                $modelID = $this->input->post('modelID', true);
                $params = $this->input->post('params', true);
                $newName = $this->input->post('newName', true) ; 

                if (!$modelID || !$id || !is_array($params)) {
                    $this->output->set_status_header('400');
                } else {
                    $response = $this->Realcas_service->updateModelLibraryEntry($user_info->id, $id, $modelID, json_encode($params), $newName); 
                }
            }
            break;
            //  updateModelLibraryEntry($user_id, $id, $model_id, $data)

        case "DELETE":
            $response = $this->Realcas_service->deleteModelLibraryEntry($user_info->id, $id);
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
                    $response = $this->Realcas_service->addModelLibraryEntry($user_info->id, $modelID, $name, json_encode($params));
                }
            }
            break;

        case "DOWNLOAD":
            $output = $this->Realcas_service->getModelLibrary($user_info->id);
            force_download('library.iml', json_encode($output));
            break;

        case "DOWNLOADAS":
            $output = $this->Realcas_service->getModelLibrary($user_info->id);
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
                    $this->Realcas_service->newModelLibrary($user_info->id);
                    $response = array(
                        'success' => true,
                        'data' => $this->Realcas_service->loadModelLibrary($user_info->id, $data_array)
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
            $this->Realcas_service->newModelLibrary($user_info->id);
            $response = array('success' => true);
            break;

        default:
            $this->output->set_status_header('405');
        }

        $this->outputJSON($response);
    }

    public function modelDetails($model_id)
    {
        $this->requireAuth();
        $user_info = $this->getAuthUser();
        $response = null;
        $model_info = $this->Modelsim_model->getModelInfoById($model_id);
        $response = array(
            'biases' => $this->Modelsim_model->getModelBiases($model_id),
            'params' => $this->Modelsim_model->getModelParams($model_id),
            'paramsTabTitle' => $this->Modelsim_model->getModelParamsTabTitle($model_id),
            'outputs' => $this->Modelsim_model->getModelOutputs($model_id),
            'hasCollection' => $model_info->hasCollection,
            'collection_info' => $model_info->collection_info
        );
        $this->outputJSON($response);
    }

    public function benchmarking($method, $model_id)
    {
        $this->requireAuth();
        $user_info = $this->getAuthUser();
        $response = null;

        switch ($method) {
        case "GET":
            $response = $this->Modelsim_model->getBenchmarkingInfo($model_id);
            break;
        default:
            $this->output->set_status_header('405');
        }

        $this->outputJSON($response);
    }

    public function paramSet($method, $model_id, $set_id = 0)
    {
        $this->requireAuth();
        $response = null;
        switch ($method) {
        case "GET":
            if ($set_id == 0) {
                $response = $this->Modelsim_model->getParamSets($model_id);
            } else {
                $response = $this->Modelsim_model->getParamSet($model_id, $set_id);
            }
            break;
        default:
            $this->output->set_status_header('405');
        }
        $this->outputJSON($response);
    }

    public function runNetlistSIM()
    {
        $this->requireAuth();
        $user_info = $this->getAuthUser();
        $response = null;
        $netlist = null;
        $modelcard = $this->Realcas_service->getAllModelCard($user_info->id);
        $netlist = $this->load->view('realcas/realcas_temple.php', array_merge($this->input->post(), array("modelCard"=>$modelcard)), true);
        $netlist = $this->Realcas_service->netlistCheck($netlist);
        $netlist_file = $this->Realcas_service->replacePlotToWRDATA($netlist);
        $this->body = $this->Realcas_service->runSPICES($netlist_file);
        //log_message('error', $response);
        $this->response();
    }

    public function simulationStatus()
    {
        $this->requireAuth();
        if (!$this->input->post()) {
            $this->output->set_status_header('405');
        } else {
            $uuid = $this->input->post('session', true);
            $response = $this->Realcas_service->spiceStatus($uuid);
        }
        // We need to encode the data using JSON_NUMERIC_CHECK option. Leon@20170728
        echo json_encode($response, JSON_NUMERIC_CHECK);
    }

    public function simulationStop()
    {
        $this->requireAuth();
        if(!$this->input->post()) {
            $this->output->set_status_header('405');
        } else {
            $uuid = $this->input->post('session', true);
            $response = $this->Realcas_service->spiceStop($uuid);
        }
    }

    public function saveasNetlist()
    {
        if(($filename = $this->input->post('saveas_name')) != '') {
            $this->saveNetlist($filename);
        } else {
            $this->saveNetlist();
        }
    }

    public function saveNetlist($filename = 'netlist')
    {
        $a['netlist'] = $this->input->post('netlist');
        $a['analyses'] = $this->input->post('analyses');
        $a['source'] = $this->input->post('source');
        $a['outvar'] = $this->input->post('outvar');
        $a['setup'] = $this->input->post('setup');
        $a['bti'] = $this->input->post('bti');
        $a['tcyc'] = $this->input->post('tcyc');
        $a['hci'] = $this->input->post('hci');
        $a['tstep'] = $this->input->post('tstep');
        $a['tpre'] = $this->input->post('tpre');
        $a['np'] = $this->input->post('np');

        //conv the \n to \r\n at EOL for fitting the NOTEPAD in windows
        $netlist = json_encode($a, JSON_NUMERIC_CHECK);
        force_download($filename . '.isp', $netlist);
    }

    public function loadNetlist()
    {
        $config['upload_path'] = './uploads/realcas';
        $config['allowed_types'] = 'isp';
        $this->load->library('upload',$config);
        $uploader = $this->upload->do_upload("Netlistupload");
        $data = $this->upload->data();
        $string = read_file($data['full_path']);
        //echo $this->upload->display_errors('<p>', '</p>');
        //var_dump($data);

        //log_message('error', $string);
        if ($string && $this->upload->file_ext ===".isp") {
            $this->body = array_merge(array("error" => false, "type"=> $this->upload->file_ext, "netlist"=>$string));
        } else {
            $this->body = array_merge(array("error" => true));
        }
        $this->response();
    }

    private function outputJSON($output)
    {
        // To make the minimum changes to apply REST_Controller
        $this->body = $output;
        $this->response();
    }
}
