<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Activities Repository.
 */
class Activities_repository extends Base_repository
{
    /**
     * Get by id
     *
     * @param $id
     * @return $activity
     *
     * @author Leon
     */
    public function getById($id)
    {
        $this->db
        ->select('id, date, content')
        ->from('activities')
        ->where('id', $id);
        return $this->db->get()->row();
    }

    /**
     * Get by options
     *
     * @param count, pageOffset, showDeleted
     * @return activities
     *
     * @author Leon
     */
    public function getByOptions($limit = 0, $offset = 0, $showDeleted = 0)
    {
        $this->db
        ->select('id, date, content')
        ->from('activities')
        ->where(array('approval_status' => 1, 'del_status' => $showDeleted))
        ->order_by('date desc')
        ->limit($limit, $offset);
        return $this->db->get()->result();
    }
}
