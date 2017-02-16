<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Organizations_repository extends Base_repository
{
    /**
     * Get Organizations
     *
     * @return Organizations
     *
     * @author Alex
     */
    public function getByOptions($limit = 0, $offset = 0, $showDeleted = 0)
    {
        $this->db
        ->select('id, name, website')
        ->from('model_groups')
        ->order_by("name asc")
        ->limit($limit, $offset);
        return $this->db->get()->result();
    }
}