<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Articles repository.
 */
class Articles_repository extends Base_repository
{
    /**
     * Get by id.
     *
     * @param $id
     * @return article
     *
     * @author Leon
     */
    public function getById($id)
    {
        $this->db
        ->select('id, name, author, publisher, year, summary, website, article_name, article_link, type')
        ->from('articles')
        ->where('id', $id);
        return $this->db->get()->row();
    }

    /**
     * Get by options
     *
     * @param count, pageOffset, showDeleted
     * @return articles
     *
     * @author Leon
     */
    public function getByOptions($limit = 0, $offset = 0, $showDeleted = 0)
    {
        $this->db
        ->select('id, name, author, publisher, year, summary, website, article_name, article_link, type')
        ->from('articles')
        ->where(array("approval_status"=> 1,"del_status"=>$showDeleted))
        ->order_by("year desc")
        ->order_by("id desc")
        ->limit($limit, $offset);

        return $this->db->get()->result();
    }
}
