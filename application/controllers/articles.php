<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class articles extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Services/Articles_service');
    }

    /**
     * Articles index, handle different method
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
                    $this->getArticles();
                    break;
                case 'POST':
                    // TODO: create article
                    $this->status = 404;
                    break;

                default:
                    $this->status = 405;
                    break;
            }
        } else {
            switch ($this->method) {
                case 'GET':
                    $this->getArticlesById($id);
                    break;
                case 'PUT':
                    // TODO: modify article
                    $this->status = 404;
                    break;
                case 'DELETE':
                    // TODO: delete article
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
    public function getArticles()
    {
        $count = $this->validateInteger($this->input->get('count'), 10);
        $page = $this->validateInteger($this->input->get('page'), 1);
        $this->body = $this->Articles_service->getByOptions($count, $page);
    }

    /**
     * Get news by id
     *
     * @param $id
     *
     * @author Leon
     */
    public function getArticlesById($id)
    {
        $this->body = $this->Articles_service->getById($id);
    }
}
