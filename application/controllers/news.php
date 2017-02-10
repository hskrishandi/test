<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class news extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Services/News_service');
    }

    /**
     * News index, handle different method
     *
     * @param $id
     *
     * @author Leon
     */
    public function index($id = null)
    {
        if ($id == null) {
            switch ($this->method) {
                case 'GET':
                    $this->getNews();
                    break;
                case 'POST':
                    // TODO: create news
                    $this->status = 404;
                    break;

                default:
                    $this->status = 405;
                    break;
            }
        } else {
            switch ($this->method) {
                case 'GET':
                    $this->getNewsById($id);
                    break;
                case 'PUT':
                    // TODO: modify news
                    $this->status = 404;
                    break;
                case 'DELETE':
                    // TODO: delete news
                    $this->status = 404;
                    break;

                default:
                    $this->status = 405;
                    break;
            }
        }
        $this->response();
    }

    /**
     * Get news
     *
     * @param $count
     *
     * @author Leon
     */
    public function getNews()
    {
        $count = $this->validateInteger($this->input->get('count'), 2);
        $page = $this->validateInteger($this->input->get('page'), 1);
        $this->body = $this->News_service->getByOptions($count, $page);
    }

    /**
     * Get news by id
     *
     * @param $id
     *
     * @author Leon
     */
    public function getNewsById($id)
    {
        $this->body = $this->News_service->getById($id);
    }
}
