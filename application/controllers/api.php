<?php

ini_set('display_errors', 'On');

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * API Controller.
 */
class api extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Services/Model_service');
        $this->load->model('Services/User_service');
        $this->load->model('Services/Activities_service');
        $this->load->model('Services/News_service');
        $this->load->model('Services/Events_service');
    }

    /**
     * Echo the version of the api.
     *
     * @return Version
     *
     * @author Leon
     */
    public function index()
    {
        echo 'i-MOS API Version 1.0';
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
        echo json_encode($result);
    }

    /**
     * Get user library.
     *
     * @param user id
     *
     * @return user library
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
        echo json_encode($result);
    }

    /**
     * Get user experience.
     *
     * @return experience
     *
     * @author Leon
     */
    public function getUserExperience()
    {
        $result = $this->User_service->getUserExperience(2);
        echo json_encode($result);
    }

    /**
     * Get activities.
     *
     * @param count
     *
     * @return $value
     *
     * @author Leon
     */
    public function getActivities()
    {
        $count = $this->input->get('count', true);
        $result = $this->Activities_service->getActivities($count);
        echo json_encode($result);
    }

    /**
     * Get News.
     *
     * @param count
     *
     * @return news
     *
     * @author Leon
     */
    public function getNews()
    {
        $count = $this->input->get('count', true);
        $result = $this->News_service->getNews($count);
        echo json_encode($result);
    }

    /**
     * Get Events
     *
     * @param count
     * @return events
     *
     * @author Leon
     */
    public function getEvents()
    {
        $count = $this->input->get('count', true);
        $result = $this->Events_service->getEvents($count);
        echo json_encode($result);
    }
}
