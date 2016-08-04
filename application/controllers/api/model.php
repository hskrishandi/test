<?php
ini_set('display_errors', 'On');

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Model API Controller.
 */
class model extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Services/Model_service');
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
        echo json_encode($result);
    }

    /**
     * Get model, bias, output, parameters by id.
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
        echo json_encode($result);
    }

    /**
     * Get user library.
     *
     * @return $value
     *
     * @author Leon
     */
    public function getUserModel()
    {
        $id = $this->input->get('id', true);
        if ($id != null) {
            $result['library'] = $this->Model_service->getUserLibraryByUserId($id);
        } else {
            $result['error'] = 'Invalid id';
        }

        echo json_encode($result);
    }
}
