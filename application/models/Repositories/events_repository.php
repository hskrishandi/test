<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Events repository.
 */
class Events_repository extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Get Events.
     *
     * @param $limit(count), $past(showpast), $offset(pageOffset), $showDeleted
     *
     * @return events
     *
     * @author Leon
     */
    public function getEvents($limit = null, $past = true, $offset = 0, $showDeleted = 0)
    {
        if ($limit == null) {
            $this->db->select('id, name, full_name, location, website, start_date, end_date')
            ->from('events')
            ->where(array('approval_status' => 1, 'del_status' => $showDeleted))
            ->order_by('start_date '.($past ? 'desc' : 'asc'))
            ->where('end_date '.($past ? '<' : '>=').' CURDATE()');
        } else {
            $this->db->select('id, name, full_name, location, website, start_date, end_date')
            ->from('events')
            ->where(array('approval_status' => 1, 'del_status' => $showDeleted))
            ->order_by('start_date '.($past ? 'desc' : 'asc'))
            ->where('end_date '.($past ? '<' : '>=').' CURDATE()')
            ->limit($limit, $offset);
        }

        return $this->db->get()->result();
    }
}
