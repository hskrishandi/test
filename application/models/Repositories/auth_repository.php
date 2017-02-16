<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Auth repository.
 */
class Auth_repository extends Base_repository
{
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
     * Fetch user id by email
     *
     * @param $email
     * @return userId
     *
     * @author Leon
     */
    public function fetchUserByEmail($email)
    {
        return $this->db->query("
            SELECT
                id,
                displayname
            FROM
                users
            WHERE
                email = '$email';
        ")->result();
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

    /**
     * Update password
     *
     * @param $userId, $password
     * @return bool
     *
     * @author Leon
     */
    public function updatePassword($userId, $password)
    {
        return $this->db->query("
            UPDATE users
            SET password = '$password'
            WHERE id = $userId;
        ");
    }
}
