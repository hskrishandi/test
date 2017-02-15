<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Auth repository.
 */
class Auth_repository extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Fetch auth user by email
     *
     * @param $email
     *
     * @return auth user
     *
     * @author Leon
     */
    public function getAuthUserByEmail($email = '')
    {
        return $this->db->query("
            SELECT
                id,
                password,
                isactivated
            FROM
                users
            WHERE
                email = '$email';
        ")->result();
    }

    /**
     * Save token for auth user
     *
     * @param $userId, $token
     * @return bool
     *
     * @author Leon
     */
    public function saveToken($userId, $token)
    {
        return $this->db->query("
            UPDATE
                users
            SET
                sessionid = '$token',
                numofvisit = numofvisit + 1
            WHERE
                id = $userId;
        ");
    }

    /**
     * Discard token for auth user
     *
     * @param $userId
     * @return bool
     *
     * @author Leon
     */
    public function discardToken($userId)
    {
        return $this->db->query("
            UPDATE
                users
            SET
                sessionid = ''
            WHERE
                id = $userId;
        ");
    }

    /**
     * Fetch auth user using token
     *
     * @param $token
     * @return auth user
     *
     * @author Leon
     */
    public function fetchAuthUserByToken($token = '')
    {
        return $this->db->query("
            SELECT
                id,
                email,
                displayname as name,
                first_name as firstName,
                last_name as lastName,
                organization,
                country,
                address,
                position,
                tel,
                fax,
                class,
                status,
                isactivated,
                photo_path as photoPath,
                photo_ext as photoExt
            FROM
                users
            WHERE
                sessionid = '$token';
        ")->result();
    }

    /**
     * Fetch user by email
     *
     * @param type $param
     * @return $value
     *
     * @author Leon
     */
    public function fetchUserByEmail($email)
    {
        $this->db
        ->select('id')
        ->from('users')
        ->where(array("email" => $email));
        return $this->db->get()->result_array();
    }

    /**
     * Create user
     *
     * @param data
     * @return $id
     *
     * @author Leon
     */
    public function createUser($data)
    {
        $this->db->insert('users', $data);
        return $this->db->insert_id();
    }

    /**
     * Create activation
     *
     * @param $uuid, $userId
     * @return bool
     *
     * @author Leon
     */
    public function createActivation($uuid, $userId)
    {
        return $this->db->insert('activation_page', array("page" => $uuid, "id" => $userId));
    }

    /**
     * Activate account
     *
     * @param $userId
     * @return $value
     *
     * @author Leon
     */
    public function activateAccount($userId)
    {
        return $this->db->query("
            UPDATE users
            SET isactivated = 1
            WHERE id = $userId;
        ");
        // return $this->db->update_string('users', array('isactivated' => 1), "id = $userId");
    }

    /**
     * Fetch activation
     *
     * @param $uuid
     * @return $userId
     *
     * @author Leon
     */
    public function fetchActivation($uuid)
    {
        return $this->db->query("
            SELECT
                id
            FROM
                activation_page
            WHERE
                page = '$uuid';
        ")->result();
    }

    /**
     * Delete activation
     *
     * @param $uuid
     * @return bool
     *
     * @author Leon
     */
    public function deleteActivation($uuid)
    {
        return $this->db
        ->delete("activation_page", array("page" => $uuid));
    }
}
