<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * News service.
 */
class News_service extends Base_service
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Repositories/News_repository');
    }

    /**
     * Get by id
     *
     * @param $id
     * @return $news
     *
     * @author Leon
     */
    public function getById($id)
    {
        return $this->News_repository->getById($id);
    }

    /**
     * Get news by options
     * Here we need to truncate the content to make it shorter for
     * frontend to display. Whole content is provided by
     * getById($id)
     *
     * @param $count, $page
     * @return $news
     *
     * @author Leon
     */
    public function getByOptions($count, $page)
    {
        $news = $this->News_repository->getByOptions($count, $count * ($page - 1));
        $result = array();
        foreach ($news as $key => $value) {
            // truncate the content shorter
            $value->content = preg_replace('/\s+?(\S+)?$/', '', substr($value->content, 0, 260)).' ...';
            array_push($result, $value);
        }
        return $result;
    }
}
