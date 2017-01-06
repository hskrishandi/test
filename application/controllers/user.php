<?php

// ini_set('display_errors', 'On');

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * API Controller.
 */
class user extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Services/User_service');
        $this->load->helper('json');
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
    public function getUserLibrary()
    {
        $id = $this->input->get('id', true);
        if ($id != null) {
            $result = $this->User_service->getUserLibraryByUserId($id);
        } else {
            $result['error'] = 'Invalid id';
        }
        outputJson($result);
    }

    /**
     * Add model to user library
     *
     * @param $userId, $modelId, $name, $data
     * @return success
     *
     * @author Leon
     */
    public function addModelToUserLibrary()
    {
        $userId = $this->input->get('userId');
        $modelId = $this->input->get('modelId');
        $name = $this->input->get('name');
        $data = $this->input->get('data');

        // TODO: may need data validation here

        if ($userId != null) {
            $result['success'] = $this->User_service->addModelToUserLibrary($userId, $modelId, $name, $data);
        } else {
            $result['error'] = 'Invalid data';
        }
        outputJson($result);
    }

    /**
     * Delete model from user library
     *
     * @param $userId, $modelId, $name
     * @return sucess
     *
     * @author Leon
     */
    public function deleteModelFromUserLibrary()
    {
        $userId = $this->input->get('userId');
        $modelId = $this->input->get('modelId');
        $name = $this->input->get('name');

        if ($userId != null) {
            $result['success'] = $this->User_service->deleteModelFromUserLibrary($userId, $modelId, $name);
        } else {
            $result['error'] = 'Invalid data';
        }
        outputJson($result);
    }
}
