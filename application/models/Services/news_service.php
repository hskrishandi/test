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
     * Get News, here we need to cut the content, make it shorter for
     * frontend to display. Frontend can retrieve the shorter
     * content instead of whole content. Whole content
     * is provided by getNewsById($id) below.\.
     *
     * @param count
     *
     * @return news array
     *
     * @author Leon
     */
    public function getNews($count = null, $id = null)
    {
        if ($id) {
            $news = $this->News_repository->getNewsById($id);
            // Get the first element from news array (mysql return array even if
            // it has only one element)
            $news = reset($news);
            $news->post_date = date('d M Y', $news->post_date);
        } else {
            $news = $this->News_repository->getNews($count);
            $result = array();
            foreach ($news as $key => $value) {
                // format the date from unix time to human readable time
            $value->post_date = date('d M Y', $value->post_date);
            // truncate the content shorter
            $value->content = preg_replace('/\s+?(\S+)?$/', '', substr($value->content, 0, 260)).' ...';
                array_push($result, $value);
            }
        }

        return $news;
    }
}
