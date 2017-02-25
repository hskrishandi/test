<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class discussions extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Services/Discussions_service');
    }

    /**
     * Discussions index
     *
     * @author Leon
     */
    public function index($id = null)
    {
        if ($id == null) {
            switch ($this->method) {
                case 'GET':
                    $this->getDiscussions();
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
                $this->getDiscussionById($id);
                    break;
                case 'PUT':
                    // TODO: modify discussion
                    $this->status = 404;
                    break;
                case 'DELETE':
                    // TODO: delete discussion
                    $this->status = 404;
                    break;

                default:
                    $this->status = 405;
                    break;
            }
        }
    }

    /**
     * Get discussions
     *
     * @param count page
     *
     * @author Leon
     */
    public function getDiscussions()
    {
        $count = $this->validateInteger($this->input->get('count'), 30);
        $page = $this->validateInteger($this->input->get('page'), 1);
        $this->body = $this->Discussions_service->getByOptions($count, $page);
        $this->response();
    }

    /**
     * Get discussion by id
     *
     * @param $id
     *
     * @author Leon
     */
    public function getDiscussionById($id)
    {
        $this->body = $this->Discussions_service->getById($id);
        $this->response();
    }

    /**
     * Discussions by user
     *
     * @param type $param
     * @return $value
     *
     * @author Leon
     */
    public function discussionsByUser()
    {
        $this->requireAuth();
        $this->status = 404;
        $this->response();
    }
}
