<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require 'BaseService.php';

/**
 * API Model Service.
 */
class ModelService extends BaseService
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Repositories/ModelRepository');
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
        $models = $this->ModelRepository->getById($id);
        // Append image url to the models
        foreach ($models as $key => $model) {
            $model->imageUrl =  resource_url('img', 'simulation/') . $model->name . '.png';
        }
        return $models;
    }
}
