<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class REST_Controller extends CI_Controller
{

    /**
     * Auth user information
     *
     * @var array
     */
    private $user = null;

    /**
     * HTTP Income Request Method
     *
     * @var array
     */
    protected $method = null;

    /**
     * HTTP Income Request Token
     *
     * @var array
     */
    private $token = null;

    /**
     * HTTP Status Code
     *
     * @var int
     */
    protected $status = null;

    /**
     * HTTP Content Type
     *
     * @var string
     */
    protected $contentType = null;

    /**
     * HTTP Body
     *
     * @var array/string/json
     */
    protected $body = null;

    /**
     * List all supported methods, the first will be the default format
     *
     * @var array
     */
    protected $supported_format = array(
        'json' => 'application/json',
        'array' => 'application/json',
        'csv' => 'application/csv',
        'html' => 'text/html',
        'jsonp' => 'application/javascript',
        'php' => 'text/plain',
        'serialized' => 'application/vnd.php.serialized',
        'xml' => 'application/xml'
    );

    /**
     * List of allowed HTTP methods
     *
     * @var array
     */
    protected $allowed_http_methods = array('get', 'delete', 'post', 'put', 'options', 'patch', 'head');

    /**
     * Constructor
     * Get header data such as method and token
     * Init some data
     *
     * @author Leon
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Services/Auth_service');

        // Get requested method
        $this->method = strtoupper($this->input->server('REQUEST_METHOD'));
        $this->token = $this->input->get_request_header('Authorization', true);
        $this->validateRequestParameters();

        // Set default header
        $this->status = 400;
        $this->contentType = $this->supported_format['json'];
    }

    /**
     * Destructor
     * When 'exit;' is called, destructor will be trigger
     *
     * @author Leon
     */
    public function __destruct()
    {
        $this->output->set_status_header($this->status);
    }

    /**
     * Comment
     *
     * @param $body
     *
     * @author Leon
     */
    protected function response($body = null)
    {
        $this->body = $body != null ?: $this->body;

        if ($this->body === true) {
            $this->status = 200;
        } elseif ($this->body === false) {
            $this->status = 500;
        } elseif (is_array($this->body) && key($this->body) === 401) {
            // if authentication has errors
            $this->status = 401;
            $this->output->set_output(json_encode(current($this->body), 128)); // 128 for JSON_PRETTY_PRINT
        } elseif ($this->body !== null && $this->body !== false) {
            $this->status = 200;
            $this->output->set_output(json_encode($this->body, 128)); // 128 for JSON_PRETTY_PRINT
        }

        $this->output
        ->set_status_header($this->status)
        ->set_content_type($this->contentType);
    }

    /**
     * Set Require Authentication
     *
     * @param bool $require
     *
     * @author Leon
     */
    protected function requireAuth($required = true)
    {
        $isLogin = $this->Auth_service->isLogin($this->token);
        if ($required && !$isLogin) {
            $this->status = 401;
            exit;
        } elseif ($required && $isLogin) {
            // Get logined user information
            $this->user = $this->Auth_service->getLoginedUser();
        }
    }

    /**
     * Get auth user
     *
     * @return $user
     *
     * @author Leon
     */
    protected function getAuthUser()
    {
        return $this->user;
    }

    /**
     * Validate request parameters
     *
     * @author Leon
     */
    private function validateRequestParameters()
    {
        if (!in_array(strtoupper($this->method), array_map('strtoupper', $this->allowed_http_methods))) {
            $this->status = 400;
            exit;
        }
    }
}
