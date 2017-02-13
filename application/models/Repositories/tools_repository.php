<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Tools_repository extends Base_repository
{
    /**
     * Get tools
     *
     * @return tools
     *
     * @author Leon
     */
    public function getByOptions($limit = 0, $offset = 0, $showDeleted = 0)
    {
        $this->db
        ->select('id, name, description, website, type')
        ->from('tools')
        ->order_by("name asc")
        ->limit($limit, $offset);
        return $this->db->get()->result();
    }
}
