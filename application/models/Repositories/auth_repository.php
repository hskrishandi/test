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
                sessionid = '$token'
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
    public function fetchAuthUserByToken($token)
    {
        return $this->db->query("
            SELECT
                id
            FROM
                users
            WHERE
                sessionid = '$token';
        ")->result();
    }
}
