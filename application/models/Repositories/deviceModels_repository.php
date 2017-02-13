<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * This is a template repository, showing you how to write a repository.
 */
class DeviceModels_repository extends Base_repository
{
    /**
     * Get all device models
     *
     * @return all device models
     *
     * @author Leon
     */
    public function getByOptions($limit = 0, $offset = 0, $showDeleted = 0)
    {
        $this->db
        ->select('id, name, author, website, status')
        ->from('device_models')
        ->order_by("name asc")
        ->limit($limit, $offset);
        return $this->db->get()->result();
    }
}
