<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Account Repositories.
 */
class Account_repository extends Base_repository
{
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
        $name = $this->db->escape_str($name);
        $data = $this->db->escape_str($data);
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
        $name = $this->db->escape_str($name);
        return $this->db->query("
            DELETE FROM
                user_param_sets
            WHERE
                user_id = $userId
                AND model_id = $modelId
                AND name = '$name'
        ");
    }

    /**
     * Update account information
     *
     * @param $userId, (array)$data
     *
     * @author Leon
     */
    public function updateAccountInfo($userId, $data)
    {
        $this->db->where('id', $userId);
        return $this->db->update('users', $data);
    }
}
