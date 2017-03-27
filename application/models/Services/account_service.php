<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Account Service.
 */
class Account_Service extends Base_service
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Repositories/Account_repository');
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
        $models = $this->Account_repository->getUserLibraryByUserId($id);
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
                        // Format user library data
                        $userLibrary = json_decode($model->data, true);
                        $formatedParameters = array();
                        if (count($userLibrary) > 0) {
                            foreach ($userLibrary as $parameter) {
                                if (array_key_exists('title', $parameter)) {
                                    $title = $parameter['title'];
                                    if (!array_key_exists($title, $formatedParameters)) {
                                        $formatedParameters[$title] = array();
                                    }
                                    unset($parameter['title']);
                                    array_push($formatedParameters[$title], $parameter);
                                }
                            }
                        }

                        // if id is same, push it to the library array
                        array_push($library, array('alias' => $model->nick_name, 'data' => $formatedParameters));
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
        $parameters = array();
        foreach (json_decode($data, true) as $title => $group) {
            if (strtolower($title) !== 'instance parameters' && strtolower($title) !== 'instance') {
                foreach ($group as $row) {
                    $row['title'] = $title;
                    unset($row['description']);
                    unset($row['unit']);
                    unset($row['default']);
                    array_push($parameters, $row);
                }
            }
        }
        $this->deleteModelFromUserLibrary($userId, $modelId, $name);
        $result = $this->Account_repository->addModelToUserLibrary($userId, $modelId, $name, json_encode($parameters));
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
        $result = $this->Account_repository->deleteModelFromUserLibrary($userId, $modelId, $name);
        return $result;
    }

    /**
     * Update account information
     *
     * @param $lastName, $firstName, $displayName, $company, $position, $address, $tel, $fax, $photo
     * @return bool
     *
     * @author Leon
     */
    public function updateAccountInfo($userId, $lastName, $firstName, $displayName, $company, $position, $address, $tel, $fax)
    {
        $data = array();
       if ($lastName !== '') {
           $data['last_name'] = $lastName;
       }
       if ($firstName !== '') {
           $data['first_name'] = $firstName;
       }
       if ($displayName !== '') {
           $data['displayname'] = $displayName;
       }
       if ($company !== '') {
           $data['organization'] = $company;
       }
       if ($position !== '') {
           $data['address'] = $address;
        }
        if ($tel !== '') {
            $data['tel'] = $tel;
        }
        if ($fax !== '') {
            $data['fax'] = $fax;
        }
        $result = $this->Account_repository->updateAccountInfo($userId, $data);
        return $result;
    }
}
