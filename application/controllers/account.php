<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * API Controller.
 */
class account extends REST_Controller
{
    /*
     * Auth user would fetch from rest_controller
     */
    private $authUser = null;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Services/Account_Service');
        // The whole class requires auth.
        $this->requireAuth();
        $this->authUser = $this->getAuthUser();
    }

    /**
     * User index
     *
     * @author Leon
     */
    public function index()
    {
        switch ($this->method) {
            case 'GET':
                $this->getUserInfo();
                break;
            case 'POST':
                // Create users
                $this->status = 405;
                break;
            case 'PUT':
                // Modify users
                $this->updateUserInfo();
                break;
            case 'DELETE':
                // Delete users
                $this->status = 405;
                break;

            default:
                $this->status = 405;
                break;
        }
        $this->response();
    }

    /**
     * Get user brief information
     *
     * @author Leon
     */
    public function getUserBriefInfo()
    {
        if ($this->method == 'GET') {
            if ($this->authUser != null) {
                $email = $this->authUser->email;
                $name = $this->authUser->name;
                $this->body = array('email' => $email, 'name' => $name);
            } else {
                $this->status = 401;
            }
        } else {
            $this->status = 405;
        }
        $this->response();
    }

    /**
     * Get user info
     *
     * @author Leon
     */
    private function getUserInfo()
    {
        $email = $this->authUser->email;
        $name = $this->authUser->name;
        $this->body = array(
            'email' => $this->authUser->email,
            'name' => $this->authUser->name,
            'firstName' => $this->authUser->firstName,
            'lastName' => $this->authUser->lastName,
            'organization' => $this->authUser->organization,
            'country' => $this->authUser->country,
            'address' => $this->authUser->address,
            'position' => $this->authUser->position,
            'tel' => $this->authUser->tel,
            'fax' => $this->authUser->fax
        );
    }

    /**
     * Update user info
     *
     * @author Leon
     */
    private function updateUserInfo()
    {
        // TODO: implement update user information
        $this->status = 405;
    }


    /**
     * User Library
     *
     * @return $value
     *
     * @author Leon
     */
    public function userLibrary()
    {
        // Get auth user id
        $userId = $this->authUser != null ? $this->authUser->id : null;
        switch ($this->method) {
            case 'GET':
                // Get user library
                $this->getUserLibrary($userId);
                break;
            case 'POST':
                // Create user library
                $this->addModelToUserLibrary($userId);
                break;
            case 'PUT':
                // Modify user library, not supported yet
                $this->status = 405;
                break;
            case 'DELETE':
                // Delete user library
                $this->deleteModelFromUserLibrary($userId);
                break;
            default:
                $this->status = 405;
                break;
        }
        $this->response();
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
    private function getUserLibrary($userId)
    {
        if ($userId != null) {
            $this->body = $this->Account_Service->getUserLibraryByUserId($userId);
        } else {
            $this->status = 401;
        }
    }

    /**
     * Add model to user library
     *
     * @param $userId, $modelId, $name, $data
     * @return success
     *
     * @author Leon
     */
    private function addModelToUserLibrary($userId)
    {
        $modelId = $this->input->post('modelId');
        $name = $this->input->post('name');
        $data = $this->input->post('data');

        // TODO: may need data validation here

        if ($userId != null) {
            $this->body = $this->Account_Service->addModelToUserLibrary($userId, $modelId, $name, $data);
        } else {
            $this->status = 401;
        }
    }

    /**
     * Delete model from user library
     *
     * @param $userId, $modelId, $name
     * @return sucess
     *
     * @author Leon
     */
    private function deleteModelFromUserLibrary($userId)
    {
        $modelId = $this->input->delete('modelId');
        $name = $this->input->delete('name');

        if ($userId != null) {
            $this->body = $this->Account_Service->deleteModelFromUserLibrary($userId, $modelId, $name);
        } else {
            $this->status = 401;
        }
    }
}
