<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class resources extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Services/Model_service');
        $this->load->model('Services/Activities_service');
        $this->load->model('Services/News_service');
        $this->load->model('Services/Events_service');
    }

    /**
     * Resources
     * Use index to be the route function, codeigniter is not supported
     * to get HTTP methods within the 'routes.php', we need this
     * function to determine the HTTP method of the
     * request.
     *
     * @param function type, $id
     *
     * @author Leon
     */
    public function index($type, $id = null)
    {
        $functionName = "";
        if ($id == null) {
            switch ($this->method) {
                case 'GET':
                    // Get resources
                    $functionName = 'get' . ucfirst($type);
                    break;
                case 'POST':
                    // Create resources
                    $functionName = 'create' . ucfirst($type);
                    break;
                default:
                    $this->status = 405;
                    break;
            }
            // check whether the function is exists in this class
            if (method_exists($this, $functionName)) {
                $this->$functionName();
            } else {
                $this->status = 404;
            }
        } else {
            switch ($this->method) {
                case 'GET':
                    // Get resources by id
                    $functionName = 'get' . ucfirst($type) . 'ById';
                    break;
                case 'PUT':
                    // Modify resources by id
                    $functionName = 'modify' . ucfirst($type) . 'ById';
                    break;
                case 'DELETE':
                    // Delete resources by id
                    $functionName = 'delete' . $type . 'ById';
                    break;
                default:
                    $this->status = 405;
                    break;
            }
            // check whether the function is exists in this class
            if (method_exists($this, $functionName)) {
                $id = $this->validateInteger($id, null);
                $this->$functionName($id);
            } else {
                $this->status = 404;
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
        $count = $this->validateInteger($this->input->get('count'));
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
     * Get upcoming events
     *
     * @param $count
     *
     * @author Leon
     */
    public function getUpcomingEvents()
    {
        $this->body = $this->Events_service->getUpcoming();
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
        $count = $this->validateInteger($this->input->get('count'), 5);
        $page = $this->validateInteger($this->input->get('page'), 1);
        $this->body = $this->Events_service->getPastByOptions($count, $page);
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

    /**
     * Get user experiences
     *
     * @param $count
     *
     * @author Leon
     */
    public function getUserExperiences()
    {
        $count = $this->validateInteger($this->input->get('count'), 2);
        $this->body = $this->Model_service->getUserExperience($count);
    }
}
