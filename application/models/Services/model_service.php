<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require 'base_service.php';

/**
 * API Model Service.
 */
class Model_service extends Base_service
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Repositories/Model_repository');
        $this->load->helper('url');
    }

    /**
     * Get model from database. Return models with imgUrl.
     *
     * @param $id
     *
     * @return model
     *
     * @author Leon
     */
    public function getById($id = null)
    {
        $models = $this->Model_repository->getById($id);
        $result = null;
        // Append image url to the models
        foreach ($models as $key => $model) {
            $model->imageUrl = resource_url('img', 'simulation/').'/'.$model->name.'.png';
        }
        if (count($models) == 1) {
            $result = $models[0];
        } elseif (count($models) > 1) {
            $result = $models;
        } else {
            $result = null;
        }

        return $result;
    }

    /**
     * Get all models with image url.
     *
     * @return all models
     *
     * @author Leon
     */
    public function getAll()
    {
        return $this->getById();
    }

    /**
     * Get model parameters by id, do some loop to reconstruct data,
     * to make it easier use for front-end.
     *
     * @param  $id
     *
     * @return After reconstruction, the data structure will look like:
     ** [{
     **     "title": $title,
     **     "parameters": [{
     **         "name": $name,
     **         "description": $description,
     **         "unit": $unit,
     **         "default": $default
     **     }]
     ** }]
     *
     * @author Leon
     */
    public function getParametersById($id)
    {
        $parameters = $this->Model_repository->getParametersById($id);
        $result = array();
        if (count($parameters) > 0) {
            $resultTmp = array();
            $parameterArrayTmp = array();
            foreach ($parameters as $parameter) {
                if (!array_key_exists($parameter->title, $resultTmp)) {
                    $parameterArrayTmp = array();
                }
                array_push($parameterArrayTmp, array('name' => $parameter->name, 'description' => $parameter->description, 'unit' => $parameter->unit, 'value' => $parameter->default));
                $resultTmp[$parameter->title] = $parameterArrayTmp;
            }
            foreach ($resultTmp as $key => $value) {
                array_push($result, array('title' => $key, 'parameters' => $value));
            }
        } else {
            $result = null;
        }

        return $result;
    }

    /**
     * Get model bias.
     *
     * @param  $id
     *
     * @return model bias
     *
     * @author Leon
     */
    public function getBiasById($id)
    {
        $result = $this->Model_repository->getBiasById($id);
        return count($result) > 0 ? $result : null;
    }

    /**
     * Get model output.
     *
     * @param  $id
     *
     * @return model output
     *
     * @author Leon
     */
    public function getOutputById($id)
    {
        $result = $this->Model_repository->getOutputById($id);
        return count($result) > 0 ? $result : null;
    }

    /**
     * Get user library by user id.
     *
     * @param  $id
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
        $models = $this->Model_repository->getUserLibraryByUserId($id);
        $result = array();
        if (count($models) > 0) {
            $resultTmp = array();
            $modelArrayTmp = array();
            foreach ($models as $model) {
                if (!array_key_exists($model->model_name, $resultTmp)) {
                    $modelArrayTmp = array();
                }
                array_push($modelArrayTmp, array('nickName' => $model->nick_name, 'data' => $model->data));
                $resultTmp[$model->model_name] = $modelArrayTmp;
            }
            foreach ($resultTmp as $key => $value) {
                array_push($result, array('modelName' => $key, 'userParameter' => $value));
            }
        } else {
            $result = null;
        }

        return $result;
    }
}
