<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Events repository.
 */
class Events_repository extends Base_repository
{
    /**
     * Get by id
     *
     * @param $id
     * @return $event
     *
     * @author Leon
     */
    public function getById($id)
    {
        $this->db
        ->select('id, name, full_name, location, website, start_date, end_date')
        ->from('events')
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
        ->select('id, name, full_name, location, website, start_date, end_date')
        ->from('events')
        ->where(array('approval_status' => 1, 'del_status' => $showDeleted))
        ->order_by('start_date desc')
        ->limit($limit, $offset);
        return $this->db->get()->result();
    }

    /**
     * Get all upcoming events
     *
     * @return $events
     *
     * @author Leon
     */
    public function getUpcoming($showDeleted = 0)
    {
        $this->db
        ->select('id, name, full_name, location, website, start_date, end_date')
        ->from('events')
        ->where(array('approval_status' => 1, 'del_status' => $showDeleted))
        ->where('end_date >= CURDATE()')
        ->order_by('start_date asc');
        return $this->db->get()->result();
    }

    /**
     * Get past events by options
     *
     * @return $events
     *
     * @author Leon
     */
    public function getPastByOptions($limit = 0, $offset = 0, $showDeleted = 0)
    {
        $this->db
        ->select('id, name, full_name, location, website, start_date, end_date')
        ->from('events')
        ->where(array('approval_status' => 1, 'del_status' => $showDeleted))
        ->where('end_date < CURDATE()')
        ->order_by('start_date desc')
        ->limit($limit, $offset);
        return $this->db->get()->result();
    }
}
