<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Model Service.
 */
class Model_service extends CI_Model
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
        foreach ($models as $key => $model) {
            // Append image url to the models
            $model->imageUrl = resource_url('img', 'simulation/').'/'.$model->name.'.png';
            // Append descriptions to models
            $model->description = $this->Model_repository->getDescriptionByName($model->name);
            // Append comments to models
            $model->comments = $this->Model_repository->getCommentsById($id);
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
                array_push($parameterArrayTmp, array('name' => $parameter->name, 'description' => $parameter->description, 'unit' => $parameter->unit, 'value' => $parameter->default, 'default' => $parameter->default));
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

    /**
     * Get random models.
     *
     * @param  $count
     *
     * @return models
     *
     * @author Leon
     */
    public function getRandomModels($count)
    {
        $result = array();
        $models = $this->getAll();
        $randomKey = array();
        if ($count == 1) {
            array_push($randomKey, array_rand($models, $count));
        } elseif ($count > 1) {
            if ($count > count($models)) {
                $count = count($models);
            }
            $randomKey = array_rand($models, $count);
        }
        foreach ($randomKey as $value) {
            array_push($result, $models[$value]);
        }

        return $result;
    }
}
