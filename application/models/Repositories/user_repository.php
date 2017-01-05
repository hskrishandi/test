<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * User Repositories.
 */
class User_repository extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Get user experience.
     *
     * @param $limit = 2, $offset = 0
     *
     * @return user experience
     *
     * @author Leon
     */
    public function getUserExperience($limit = 2, $offset = 0)
    {
        $this->db->select('ue.comment, ue.date, u.first_name, u.last_name, u.organization')
        ->from('user_experience ue')
        ->join('users u', 'u.id = ue.user_id', 'inner')
        ->where('ue.approval_status', 1)
        ->order_by('ue.date desc')
        ->limit($limit, $offset);
        return $this->db->get()->result();
    }

    /**
     * Get user library.
     *
     * @param $id
     *
     * @return $value
     *
     * @author Leon
     */
    public function getUserLibraryByUserId($id)
    {
        return $this->db->query("
            SELECT
                model.id As model_id,
                model.short_name AS model_name,
                param.name AS nick_name,
                param.data
            FROM
                model_info AS model
                    LEFT JOIN
                (SELECT
                    *
                FROM
                    user_param_sets) AS param ON param.model_id = model.id
            WHERE
                param.user_id = $id
            ORDER BY model_id;
        ")->result();
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
        return $this->db->query("
            INSERT INTO
                user_param_sets
                (id, user_id, model_id, name, data, last_modify)
            VALUES
                (NULL, '$userId', '$modelId', '$name', '$data', CURRENT_TIMESTAMP)
        ");
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
        return $this->db->query("
            DELETE FROM
                user_param_sets
            WHERE
                user_id = $userId
                AND model_id = $modelId
                AND name = '$name'
        ");
    }
}
