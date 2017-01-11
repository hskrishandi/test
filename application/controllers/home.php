<?php

class home extends REST_Controller
{
    /**
     * Echo the version of the api.
     *
     * @return Version
     *
     * @author Leon
     */
    public function index()
    {
        if ($this->method == "GET") {
            $this->body = 'i-MOS API Version 2.0';
        } else {
            $this->status = 405;
        }
        $this->response();
    }

    /**
     * 404 Page Not Found
     *
     * @author Leon
     */
    public function notFound()
    {
        $this->status = 404;
        $this->response();
    }
}
