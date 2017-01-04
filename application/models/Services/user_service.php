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
     **     "modelName": $modelName,
     **     "userParameter": [{
     **         "nick_name": $nickName,
     **         "data": $data,
     **     }]
     ** }]
     */
    public function getUserLibraryByUserId($id)
    {
        $models = $this->User_repository->getUserLibraryByUserId($id);
        $result = array();
        if (count($models) > 0) {
            $resultTmp = array();
            $modelArrayTmp = array();
            foreach ($models as $model) {
                if (!array_key_exists($model->model_name, $resultTmp)) {
                    $modelArrayTmp = array();
                }
                array_push($modelArrayTmp, array('alias' => $model->nick_name, 'data' => $model->data));
                $resultTmp[$model->model_name] = $modelArrayTmp;
            }
            foreach ($resultTmp as $key => $value) {
                array_push($result, array('model' => $key, 'library' => $value));
            }
        } else {
            $result = null;
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
