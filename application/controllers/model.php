<?php

// ini_set('display_errors', 'On');

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * API Controller.
 */
class model extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Services/Model_service');
        $this->load->helper('json');
    }

    /**
     * Get all models.
     *
     * @return models in json format
     *
     * @author Leon
     */
    public function getAllModels()
    {
        $result = $this->Model_service->getAll();
        outputJson($result);
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
    public function getModelById()
    {
        $id = $this->input->get('id', true);
        if ($id != null) {
            $result['model'] = $this->Model_service->getById($id);
            $result['bias'] = $this->Model_service->getBiasById($id);
            $result['output'] = $this->Model_service->getOutputById($id);
            $result['parameters'] = $this->Model_service->getParametersById($id);
        } else {
            $result['error'] = 'Invalid id';
        }
        outputJson($result);
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
        $count = $this->input->get('count', true);
        if ($count != null) {
            $result = $this->Model_service->getRandomModels($count);
        } else {
            $result = $this->Model_service->getRandomModels(5);
        }
        outputJson($result);
    }
}
