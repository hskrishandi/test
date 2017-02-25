<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Discussions_service extends Base_service
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Repositories/Discussions_repository');
        $this->load->helper('url');
    }

    /**
     * Get discussions by options
     *
     * @param $count, $page
     *
     * @return discussions
     *
     * @author Leon
     */
    public function getByOptions($count, $page)
    {
        $discussions = $this->Discussions_repository->getByOptions($count, $count * ($page - 1));
        foreach ($discussions as $key => $discussion) {
            // Add the actual server url to images
            $discussion->avatar = !empty($discussion->avatar) ? resource_url('user_img', $discussion->avatar) : resource_url('img', 'usericon.gif');
            // Remove html tags and html entity, trim the content to be shorter
            $discussion->content = preg_replace('/\s+?(\S+)?$/', '', substr(strip_tags(html_entity_decode($discussion->content)), 0, 100)).' ...';
        }
        return $discussions;
    }

    /**
     * Get discussion by id
     *
     * @param $id
     * @return $value
     *
     * @author Leon
     */
    public function getById($id)
    {
        $discussion = $this->Discussions_repository->getById($id);
        if (count($discussion) > 0) {
            reset($discussion);
            $discussion = current($discussion);
            $discussion->avatar = !empty($discussion->avatar) ? resource_url('user_img', $discussion->avatar) : resource_url('img', 'usericon.gif');
            $discussion->content = preg_replace('/(<script(\s|\S)*?<\/script>)|(<style(\s|\S)*?<\/style>)|(<!--(\s|\S)*?-->)|(<\/?(\s|\S)*?>)|(&nbsp;)/', '', $discussion->content);
        }
        return $discussion;
    }
}
