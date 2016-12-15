<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class activities extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->helper(array('template_inheritance', 'html', 'url', 'date'));
        $this->load->model('Resources_model');
        $this->load->model('Account_model');
        $this->config->load('news_event');
        $this->load->library('pagination');
    }

    public function index()
    {

        $data = array(
			'activities' => $this->Resources_model->get_activities_adv('undelete')
		);

		$this->load->view('activities/index', $data);
    }

    public function news($id = 0)
    {
        if ($id > 0) {
            $data = array('display_list' => false,
            'userInfo' => $this->Account_model->isLogin(),
            'news_details' => $this->Resources_model->get_news_details($id),
            'news_status' => $this->Resources_model->check_inapproavl_news($id), );
        } else {
            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $data = array(
                'display_list' => true,
                'userInfo' => $this->Account_model->isLogin(),
                'news' => $this->Resources_model->get_news_adv('undelete'),
                'links' => $this->pagination->create_links(),
            );
        }
        $this->load->view('news_event/news', $data);
    }
}

/* End of file activities.php */
/* Location: ./application/controllers/activities.php */
