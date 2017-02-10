<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Articles service.
 */
class Articles_service extends Base_service
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Repositories/Articles_repository');
    }

    /**
     * Get by id
     *
     * @param $id
     * @return $article
     *
     * @author Leon
     */
    public function getById($id)
    {
        return $this->Articles_repository->getById($id);
    }

    /**
     * Get articles by options
     *
     * @param $count, $page
     * @return $articles
     *
     * @author Leon
     */
    public function getByOptions($count, $page)
    {
        $result = $this->Articles_repository->getByOptions($count, $count * ($page - 1));
        return $result;
    }
}
