<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * News repository.
 */
class News_repository extends Base_repository
{
    /**
     * Get News By id.
     *
     * @param $id
     * @return news
     *
     * @author Leon
     */
    public function getById($id)
    {
        $this->db
        ->select('id, post_date, title, source_link, content')
        ->from('news')
        ->where('id', $id);
        return $this->db->get()->row();
    }

    /**
     * Get by options
     *
     * @param count, pageOffset, showDeleted
     * @return news
     *
     * @author Leon
     */
    public function getByOptions($limit = 0, $offset = 0, $showDeleted = 0)
    {
        $this->db->select('id, post_date, title, source_link, content')
        ->from('news')
        ->where(array('approval_status' => 1, 'del_status' => $showDeleted))
        ->order_by('post_date desc')
        ->limit($limit, $offset);
        return $this->db->get()->result();
    }
}
