<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Activities Repository.
 */
class Activities_repository extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Get activities.
     *
     * @param count
     *
     * @return activities
     *
     * @author Leon
     */
    public function getActivities($limit = null, $offset = 0, $showDeleted = 0)
    {
        if ($limit == null) {
            $this->db->select('id, UNIX_TIMESTAMP(date) as date, content')
            ->from('activities')
            ->where(array('approval_status' => 1, 'del_status' => $showDeleted))
            ->order_by('date desc');
        } else {
            $this->db->select('id, UNIX_TIMESTAMP(date) as date, content')
            ->from('activities')
            ->where(array('approval_status' => 1, 'del_status' => $showDeleted))
            ->order_by('date desc')
            ->limit($limit, $offset);
        }

        return $this->db->get()->result();
    }
}
