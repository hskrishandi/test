<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require 'BaseRepository.php';

/**
 * API Model Model.
 */
class ModelRepository extends BaseRepository
{
    /**
     * Get model from database. Return single model if $id not null,
     * if $id is null.
     *
     * @param $id
     *
     * @return model
     *
     * @author Leon
     */
    public function getById($id)
    {
        if ($id === null) {
            $this->db->from('model_info')->order_by('id asc');
        } else {
            $this->db->from('model_info')->where('id', $id);
        }

        return $this->db->get()->result();
    }
}
