<?php

// ini_set('display_errors', 'On');

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class resources extends CI_Controller
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
     * Get user experience.
     *
     * @return experience
     *
     * @author Leon
     */
    public function getUserExperience()
    {
        $result = $this->User_service->getUserExperience(2);
        echo json_encode($result);
    }

    /**
     * Get activities.
     *
     * @param count
     *
     * @return $value
     *
     * @author Leon
     */
    public function getActivities()
    {
        $count = $this->input->get('count', true);
        $result = $this->Activities_service->getActivities($count);
        echo json_encode($result);
    }

    /**
     * Get News with the count.
     *
     * @return news
     *
     * @author Leon
     */
    public function getNews()
    {
        $count = $this->input->get('count', true);
        $id = $this->input->get('id', true);
        // TODO: we might need to limit the count or even add page to
        // truncate the return size.
        $result = $this->News_service->getNews($count, $id);
        echo json_encode($result);
    }

    /**
     * Get Events.
     *
     * @param count
     *
     * @return events
     *
     * @author Leon
     */
    public function getEvents()
    {
        $count = $this->input->get('count', true);
        // TODO: we might need to limit the count or even add page to
        // truncate the return size.
        $result = $this->Events_service->getEvents($count);
        echo json_encode($result);
    }
}
