<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * News repository.
 */
class News_repository extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Get News.
     *
     * @param count, pageOffset, showDeleted
     *
     * @return news
     *
     * @author Leon
     */
    public function getNews($limit = null, $offset = 0, $showDeleted = 0)
    {
        if ($limit == null) {
            $this->db->select('id, UNIX_TIMESTAMP(post_date) as post_date, title, content')
            ->from('news')
            ->where(array('approval_status' => 1, 'del_status' => $showDeleted))
            ->order_by('post_date desc');
        } else {
            $this->db->select('id, UNIX_TIMESTAMP(post_date) as post_date, title, content')
            ->from('news')
            ->where(array('approval_status' => 1, 'del_status' => $showDeleted))
            ->order_by('post_date desc')
            ->limit($limit, $offset);
        }

        return $this->db->get()->result();
    }
}
