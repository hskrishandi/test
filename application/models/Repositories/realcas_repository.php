<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Realcas_repository extends Base_repository
{
    public function getModelLibrary($user_id)
    {
        $this->db->select('model_info.id as model_id, model_info.short_name as model_name, user_param_sets.id as id, user_param_sets.name, user_param_sets.data')->from('model_info')
            ->join('user_param_sets', 'model_info.id = user_param_sets.model_id', 'left')
            ->where('user_param_sets.user_id', $user_id)			
            ->order_by("model_id asc")->distinct();

        return $this->db->get()->result();
    }

    public function getModelLibraryEntry($user_id, $id)
    {
        $this->db->select('data')->from('user_param_sets')->where(array("user_id" => $user_id, "id" => $id));
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $result = $query->row();
            return json_decode($result->data);
        }

        return null;
    }

    public function addModelLibraryEntry($user_id, $model_id, $name, $data)
    {
        $this->db->select('id')->from('user_param_sets')->where(array("user_id" => $user_id, "model_id" => $model_id, "name" => $name));
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $result = $query->row();
            $this->deleteModelLibraryEntry($user_id, $result->id);
        }

        $this->db->insert('user_param_sets', array("user_id" => $user_id, "model_id" => $model_id, "name" => $name, "data" => $data));
        return ($this->db->affected_rows() > 0 ? $this->db->insert_id() : -1);
    }

    public function deleteModelLibraryEntry($userId, $modelId) {
        $this->db->where(array("id" => $modelId, "user_id" => $userId));
        $this->db->delete('user_param_sets');
        return $this->db->affected_rows() > 0;
    }

    public function deleteModelLibrary($userId, $realcasModels) {
        $this->db->where('user_id', $userId)->where_in('model_id', $realcasModels);
        $this->db->delete('user_param_sets');
        return $this->db->affected_rows();
    }

    public function loadModelLibrary($data) {
        $this->db->insert_batch('user_param_sets', $data);
        return $this->db->affected_rows();
    }

    public function updateModelLibraryEntry($user_id, $id, $model_id, $data, $newName)
    {
        $this->db->where(array("id" => $id, "model_id" => $model_id, "user_id" => $user_id));
        $this->db->update('user_param_sets', array("data" => $data, "name"=>$newName, "last_modify" => date('Y-m-d H:i:s')));
        return $this->db->affected_rows() > 0;
    }

    public function getAllModelCard($userId) {
        $this->db->select('user_param_sets.model_id AS "model_id", model_info.short_name  AS "model_short_name",model_info.name AS "model_name", user_param_sets.name AS "library_name", user_param_sets.data AS "user_param_data"')
            ->from('user_param_sets')->join('model_info', 'user_param_sets.model_id=model_info.id')
            ->where(array('user_param_sets.user_id' => $userId));
        $query = $this->db->get();
        return $query->result();
    }
}
