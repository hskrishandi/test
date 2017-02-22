<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class discussion extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Services/Discussion_service');
    }

    /**
     * Discussion index
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
     * @param type $param
     * @return $value
     *
     * @author Leon
     */
    public function getDiscussions()
    {

        $this->response();
    }
}
