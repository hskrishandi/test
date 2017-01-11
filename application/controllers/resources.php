<?php

// ini_set('display_errors', 'On');

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class resources extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Services/User_service');
        $this->load->model('Services/Activities_service');
        $this->load->model('Services/News_service');
        $this->load->model('Services/Events_service');
    }

    /**
     * Resources
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
                $this->$functionName($id);
            } else {
                $this->status = 404;
            }
        }
        $this->response();
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
        $count = $this->input->get('count') ?: 2;
        $this->body = $this->User_service->getUserExperience($count);
    }

    /**
     * Create user experience
     *
     * @param type $param
     *
     * @author Leon
     */
    public function createUserExperiences()
    {
        $this->status = 404;
    }

    /**
     * Get user experience by id
     *
     * @param $id
     *
     * @author Leon
     */
    public function getUserExperiencesById($id)
    {
        $this->status = 404;
    }

    /**
     * Modify user experience by id
     *
     * @return $id
     *
     * @author Leon
     */
    public function modifyUserExperiencesById($id)
    {
        $this->status = 404;
    }

    /**
     * Delete user experience by id
     *
     * @param $id
     * @return $value
     *
     * @author Leon
     */
    public function deleteUserExperiencesById($id)
    {
        $this->status = 404;
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
        $count = $this->input->get('count') ?: 6;
        $this->body = $this->Activities_service->getActivities($count);
    }

    /**
     * Create activity
     *
     * @param type $param
     *
     * @author Leon
     */
    public function createActivities()
    {
        $this->status = 404;
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
        $this->status = 404;
    }

    /**
     * Modify activity by id
     *
     * @return $id
     *
     * @author Leon
     */
    public function modifyActivitiesById($id)
    {
        $this->status = 404;
    }

    /**
     * Delete activity by id
     *
     * @param $id
     * @return $value
     *
     * @author Leon
     */
    public function deleteActivitiesById($id)
    {
        $this->status = 404;
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
        $count = $this->input->get('count');
        $id = $this->input->get('id');
        // TODO: we might need to limit the count or even add page to
        // truncate the return size.
        $this->body = $this->News_service->getNews($count, $id);
    }

    /**
     * Create news
     *
     * @param type $param
     *
     * @author Leon
     */
    public function createNews()
    {
        $this->status = 404;
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
        $this->status = 404;
    }

    /**
     * Modify news by id
     *
     * @return $id
     *
     * @author Leon
     */
    public function modifyNewsById($id)
    {
        $this->status = 404;
    }

    /**
     * Delete news by id
     *
     * @param $id
     * @return $value
     *
     * @author Leon
     */
    public function deleteNewsById($id)
    {
        $this->status = 404;
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
        $count = $this->input->get('count');
        // TODO: we might need to limit the count or even add page to
        // truncate the return size.
        $this->body = $this->Events_service->getEvents($count);
    }

    /**
     * Create event
     *
     * @param type $param
     *
     * @author Leon
     */
    public function createEvents()
    {
        $this->status = 404;
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
        $this->status = 404;
    }

    /**
     * Modify event by id
     *
     * @return $id
     *
     * @author Leon
     */
    public function modifyEventsById($id)
    {
        $this->status = 404;
    }

    /**
     * Delete event by id
     *
     * @param $id
     * @return $value
     *
     * @author Leon
     */
    public function deleteEventsById($id)
    {
        $this->status = 404;
    }
}
