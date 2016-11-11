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
}
