<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class events extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Services/Events_service');
    }

    /**
     * Events index, handle different method
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
                    $this->getEvents();
                    break;
                case 'POST':
                    // TODO: create events
                    $this->status = 404;
                    break;

                default:
                    $this->status = 405;
                    break;
            }
        } else {
            switch ($this->method) {
                case 'GET':
                    $this->getEventsById($id);
                    break;
                case 'PUT':
                    // TODO: modify events
                    $this->status = 404;
                    break;
                case 'DELETE':
                    // TODO: delete events
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
     * Get events
     *
     * @param $count
     *
     * @author Leon
     */
    public function getEvents()
    {
        $count = $this->validateInteger($this->input->get('count'), 5);
        $page = $this->validateInteger($this->input->get('page'), 1);
        $this->body = $this->Events_service->getByOptions($count, $page);
    }

    /**
     * Get event by id
     *
     * @param $id
     *
     * @author Leon
     */
    public function getEventsById($id)
    {
        $this->body = $this->Events_service->getById($id);
    }

    /**
     * Get upcoming events
     *
     * @param $count
     *
     * @author Leon
     */
    public function getUpcomingEvents()
    {
        if ($this->method == 'GET') {
            $this->body = $this->Events_service->getUpcoming();
        } else {
            $this->status = 405;
        }
        $this->response();
    }

    /**
     * Get past events
     *
     * @param $count
     *
     * @author Leon
     */
    public function getPastEvents()
    {
        if ($this->method == 'GET') {
            $count = $this->validateInteger($this->input->get('count'), 5);
            $page = $this->validateInteger($this->input->get('page'), 1);
            $this->body = $this->Events_service->getPastByOptions($count, $page);
        } else {
            $this->status = 405;
        }
        $this->response();
    }
}
