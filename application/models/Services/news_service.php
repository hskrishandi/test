<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * News service.
 */
class News_service extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Repositories/News_repository');
        $this->load->helper('url');
    }

    /**
     * Get News
     *
     * @param count
     * @return $value
     *
     * @author Leon
     */
    public function getNews($count)
    {
        $news = $this->News_repository->getNews($count);
        $result = array();
        foreach ($news as $key => $value) {
            $value->post_date = date('d M Y', $value->post_date);
            array_push($result, $value);
        }
        return $news;
    }
}
