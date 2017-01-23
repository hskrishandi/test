<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * API Controller.
 */
class models extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Services/Model_service');
    }

    /**
     * Model index
     *
     * @author Leon
     */
     public function index($id = null)
     {
         if ($id == null) {
             switch ($this->method) {
                 case 'GET':
                     // Get all models
                     $this->getAllModels();
                     break;
                 default:
                     $this->status = 405;
                     break;
             }
         } else {
             $id = $this->validateInteger($id);
             switch ($this->method) {
                 case 'GET':
                     // Get model by id
                     $this->getModelById($id);
                     break;
                 case 'PUT':
                     // Modify a model
                     $this->status = 404;
                     break;
                 case 'DELETE':
                     // Delete model by id
                     $this->status = 404;
                     break;
                 default:
                     $this->status = 405;
                     break;
             }
         }
         $this->response();
     }


    /**
     * Get all models.
     *
     * @return models in json format
     *
     * @author Leon
     */
    private function getAllModels()
    {
        if ($this->method == 'GET') {
            $this->body = $this->Model_service->getAll();
        } else {
            $this->status = 405;
        }
    }

    /**
     * Get model, bias, output, parameters by id.
     *
     * @param model id
     *
     * @return model Json
     *
     * @author Leon
     */
    private function getModelById($id)
    {
        $this->requireAuth();
        $result['model'] = $this->Model_service->getById($id);
        $result['bias'] = $this->Model_service->getBiasById($id);
        $result['output'] = $this->Model_service->getOutputById($id);
        $result['parameters'] = $this->Model_service->getParametersById($id);
        $this->body = $result;
        $this->response();
    }

    /**
     * Get random models.
     *
     * @param count
     *
     * @return models
     *
     * @author Leon
     */
    public function getRandomModels()
    {
        $count = $this->validateInteger($this->input->get('count'), 5);
        if ($this->method == "GET") {
            $this->body = $this->Model_service->getRandomModels($count);
        } else {
            $this->status = 405;
        }
        $this->response();
    }
}
