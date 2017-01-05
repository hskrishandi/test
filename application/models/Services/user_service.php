<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * User Service.
 */
class User_service extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Repositories/User_repository');
        $this->load->helper('url');
    }

    /**
     * Get user experience.
     *
     * @param  $count, $offset
     *
     * @return user experience
     *
     * @author Leon
     */
    public function getUserExperience($count)
    {
        $experiences = $this->User_repository->getUserExperience($count);
        return $experiences;
    }

    /**
     * Get user library by user id.
     *
     * @param  user id
     *
     * @return user library
     *
     * @author Leon
     *
     ** [{
     **     "id": $modelId
     **     "name": $modelName,
     **     "library": [{
     **         "alias": $nickName,
     **         "data": $data,
     **     }]
     ** }]
     */
    public function getUserLibraryByUserId($id)
    {
        $models = $this->User_repository->getUserLibraryByUserId($id);
        $result = array();
        if (count($models) > 0) {
            // loop all the models, and constrcut the basic structure
            foreach ($models as $model) {
                array_push($result, array('id' => $model->model_id, 'name' => $model->model_name, 'library' => array()));
            }
            // remove duplicated
            $result = array_unique($result, SORT_REGULAR);
            // rearrange index after array_unique
            $result = array_values($result);
            // loop the structured array
            foreach ($result as $resultIndex => $value) {
                // make a new temp library
                $library = array();
                // loop the models
                foreach ($models as $modelIndex => $model) {
                    // compare the model id
                    if ($model->model_id == $value['id']) {
                        // if id is same, push it to the library array
                        array_push($library, array('alias' => $model->nick_name, 'data' => $model->data));
                        // remove the model after pushing to reduce the loop
                        unset($models[$modelIndex]);
                    }
                }
                // assign the temp library to structured array
                $result[$resultIndex]['library'] = $library;
            }
        }
        return $result;
    }

    /**
     * Add model to user library
     *
     * @param $userId, $modelId, $name, $data
     * @return bool
     *
     * @author Leon
     */
    public function addModelToUserLibrary($userId, $modelId, $name, $data)
    {
        $this->deleteModelFromUserLibrary($userId, $modelId, $name);
        $result = $this->User_repository->addModelToUserLibrary($userId, $modelId, $name, $data);
        return $result;
    }

    /**
     * Delete model from user library
     *
     * @param $userId, $modelId, $name
     * @return bool
     *
     * @author Leon
     */
    public function deleteModelFromUserLibrary($userId, $modelId, $name)
    {
        $result = $this->User_repository->deleteModelFromUserLibrary($userId, $modelId, $name);
        return $result;
    }
}
