<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class activities extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Services/Activities_service');
    }

    /**
     * Activities index, handle different method
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
                    $this->getActivities();
                    break;
                case 'POST':
                    // TODO: create activity
                    $this->status = 404;
                    break;

                default:
                    $this->status = 405;
                    break;
            }
        } else {
            switch ($this->method) {
                case 'GET':
                    $this->getActivitiesById($id);
                    break;
                case 'PUT':
                    // TODO: modify activity
                    $this->status = 404;
                    break;
                case 'DELETE':
                    // TODO: delete activity
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
     * Get activities
     *
     * @param $count
     *
     * @author Leon
     */
    public function getActivities()
    {
        $count = $this->validateInteger($this->input->get('count'), 6);
        $page = $this->validateInteger($this->input->get('page'), 1);
        $this->body = $this->Activities_service->getByOptions($count, $page);
    }

    /**
     * Get activity by id
     *
     * @param $id
     *
     * @author Leon
     */
    public function getActivitiesById($id)
    {
        $this->body = $this->Activities_service->getById($id);
    }
}
