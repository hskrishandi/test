<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Model Service.
 */
class Model_service extends Base_service
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Ngspice_model');
        $this->load->model('Modelsim_model');
        $this->load->model('Repositories/Model_repository');
        $this->load->library('parser');
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
            $model->comments = $this->Model_repository->getCommentsById($model->id);
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
     **{
     **  $title(e.g. Model Parameters): [
     **  {
     **    "name": $name,
     **    "description": $description,
     **    "unit": $unit,
     **    "default": $default
     **  },
     **  ],
     **}
     *
     * @author Leon
     */
    public function getParametersById($id)
    {
        $parameters = $this->Model_repository->getParametersById($id);
        $result = array();
        if (count($parameters) > 0) {
            foreach ($parameters as $parameter) {
                if (!array_key_exists($parameter->title, $result)) {
                    $result[$parameter->title] = array();
                }
                array_push($result[$parameter->title], array('name' => $parameter->name, 'description' => $parameter->description, 'unit' => $parameter->unit, 'value' => $parameter->default, 'default' => $parameter->default));
            }
        }
        /*
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
        */
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
            $randomKey = array_rand($models, min($count, count($models)));
        } else {
            return false;
        }
        foreach ($randomKey as $value) {
            array_push($result, $models[$value]);
        }
        return $result;
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
        return $this->Model_repository->getUserExperience($count);
    }


    /**
     * Model simulaiton
     *
     * @note This funciton uses the 'old model' like Ngspice_model instead of
     * Service and Repository.
     * Modify from application/controllers/modelsim.php:520
     *
     * @param $modelId, $biases, $params, $biasingMode, $benchmarkingId
     *
     * @return simulation id
     *
     * @author Leon
     */
    public function simulate($modelId, $biases, $params, $biasingMode, $benchmarkingId = null)
    {
        if (!$modelID || !is_array($biases) || !is_array($params || !is_array($biases["variable"]))) {
            return false;
        }

        //To prevent user wrongly type step = 0 or < 0.00001 which make server overload
        foreach ($biases["variable"] as $vars) {
            if (!is_numeric($var["step"]) || $var["step"] == 0 || abs($var["step"]) < 0.00001) {
                return false;
            } else {
                $var["step"] = abs($var["step"]);
                if (!isset($biases["fixed"])) {
                    $biases["fixed"] = array();
                }
                if (!isset($params["model"])) {
                    $params["model"] = array();
                }
                if (!isset($params["instance"])) {
                    $params["instance"] = array();
                }
                foreach (array("model", "instance") as $arr) {
                    foreach ($params[$arr] as $key => $param) {
                        if (!isset($param["value"]) || trim($param["value"]) == '') {
                            unset($params[$arr][$key]);
                        }
                    }
                }
                // Check biasing mode, and get netlist
                if ($biasingMode == "General Biasing") {
                    $netlist = $this->composeNetlist($modelID, $biases, $params);
                } elseif ($biasingMode == "Benchmarking") {
                    if ($benchmarkingId) {
                        $netlist = $this->composeNetlist($modelID, $biases, $params, $benchmarkingId);
                    } else {
                        // No benchmarking id
                        return false;
                    }
                } else {
                    // No biasing mode, skip
                    return false;
                }
                // Run simulation
                if ($netlist != null) {
                    $response = $this->Ngspice_model->simulate($netlist);
                } else {
                    return false;
                }
            }
        }

        // $response would be simulation id
        return $response;
    }

    /**
     * Compose netlist using data
     *
     * @note This funciton uses the 'old model' like Ngspice_model instead of
     * Service and Repository.
     * modify from application/controllers/modelsim.php:638
     *
     * @param $modelID, $biases, $params, $benchmarkID
     *
     * @return netlist
     *
     * @author Leon
     */
    private function composeNetlist($modelID, $biases, $params, $benchmarkID = -1)
    {
        // Get model info
        $model_info = $this->Modelsim_model->getModelInfoById($modelID);
        if ($model_info == null) {
            return null;
        }
        // Check benchmarking info if benchmarkID exists
        if ($benchmarkID != -1) {
            $benchmark_info = $this->Modelsim_model->getBenchmarkingInfoById($benchmarkID);
            if ($benchmark_info == null) {
                return null;
            }
        }

        // Construct input data for composing netlist
        $input = array();
        $input["prefix"] = $model_info->prefix;
        $input["suffix"] = $model_info->suffix;
        $input["mname"] = $input["type"] = $model_info->type;
        //if $params["type"] != null, this means the model-id is 9 and need to set the type in netlist manually.
        if ($params["type"] != null) {
            $input["mname"] = $input["type"] = $params["type"];
        }
        $input["iname"] = substr($model_info->name, 0, 7 - strlen($input["suffix"]));

        if ($benchmarkID == -1) {
            $model_biases = $this->Modelsim_model->getModelBiases($modelID);
            $model_outputs = $this->Modelsim_model->getModelOutputs($modelID);
        } else {
            $model_biases = $this->Modelsim_model->getBenchmarkingBiases($benchmarkID);
            $model_outputs = $this->Modelsim_model->getBenchmarkingOutputs($benchmarkID, $modelID);
            $model_ctrl = $this->Modelsim_model->getBenchmarkingControlSrc($benchmarkID, $modelID);
            $m_outputs = $this->Modelsim_model->getModelOutputs($modelID);//newly added
            foreach ($model_ctrl as $ctrl) {
                $input['ctrlsources'][] = array("ctrlname" => $ctrl->ctrl_src, "bias" => $ctrl->bias, "indsource" => $ctrl->ind_src, "ctrlval" => $ctrl->ctrl_val);
            }
        }

        $fixed_params = $this->Modelsim_model->getModelParams($modelID, false);

        $outputs = ' ';
        foreach ($model_outputs as $output) {
            $outputs .= $this->parser->parse_string($output->variable, $input, true) . ' ';
        }

        //this part is newly added, $moutputs is added to fix bugs, $moutputs stand for model output while $outputs stand for model output when benchmarkID = -1 and benchmark output when benchmarkID != -1
        if ($benchmarkID != -1) {
            $outputs1 = ' ';
            foreach ($m_outputs as $output) {
                $outputs1 .= $this->parser->parse_string($output->variable, $input, true) . ' ';
            }
            $input['moutputs'] = $outputs1;
        }

        $input['outputs'] = $outputs;
        $input['iparams'] = $params["instance"];
        $input['mparams'] = $params["model"];
        $input['varsources'] = $biases["variable"];
        foreach ($fixed_params["instance"] as $param) {
            $input['iparams'][] = array("name" => $param->name, "value" => $param->default);
        }
        foreach ($fixed_params["model"] as $param) {
            $input['mparams'][] = array("name" => $param->name, "value" => $param->default);
        }
        $input['sources'] = array();
        foreach ($model_biases as $bias) {
            $input['sources'][] = array("name" => $bias->name, "value" => $bias->default);
        }
        foreach ($biases["fixed"] as $b2) {
            foreach ($input['sources'] as $key => $bias) {
                if ($b2["name"] == $bias["name"]) {
                    $input['sources'][$key]["value"] = $b2["value"];
                    break;
                }
            }
        }

        // Get netlist
        if ($benchmarkID != -1) {
            return $this->Ngspice_model->getNetlistForModelSim($input, $benchmark_info->name);
        } else {
            return $this->Ngspice_model->getNetlistForModelSim($input);
        }
    }
}
