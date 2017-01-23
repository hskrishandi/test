<?php

// ini_set('display_errors', 'On');

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
    protected $allowed_http_methods = array('get', 'delete', 'post', 'put');

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
        $this->preflight();
    }

    /**
     * Response to the request
     *
     * @param $body
     *
     * @author Leon
     */
    protected function response()
    {
        // Status code is not set, else just response the error code, so
        // we say that "status code > body"
        if ($this->status === null) {
            if ($this->body === true) {
                // if the body is true without any other contents
                $this->status = 200;
            } elseif ($this->body === false) {
                // if the body is false without any other contents
                $this->status = 500;
            } elseif (is_array($this->body) && key($this->body) === 401) {
                // if authentication has errors
                $this->status = 401;
                $this->output->set_output(json_encode(current($this->body))); // 128 for JSON_PRETTY_PRINT
            } elseif ($this->body !== null && $this->body !== false) {
                // if nothing goes wrong
                $this->status = 200;
                $this->output->set_output(json_encode($this->body)); // 128 for JSON_PRETTY_PRINT
            }
            // Set content type
            $this->output->set_content_type($this->contentType);
        }
        // Set status code
        $this->output->set_status_header($this->status);
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
            $this->exitWithStatus(401);
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
     * Validate number
     * Only for integers >= 0
     *
     * @param request parameter, default value
     * @return number if valid, false if not valid
     *
     * @author Leon
     */
    protected function validateInteger($param, $default = 0)
    {
        if ($param) {
            // if the request param is not empty or null
            if (preg_match('/^\d+$/', $param) && (int)$param >= 0) {
                // check param is non-negative integer
                return (int)$param;
            } else {
                // the parameter is not valid
                $this->exitWithStatus(400);
            }
        } else {
            return (int)$default;
        }
    }

    /**
     * Check the request header
     *
     * @author Leon
     */
    private function preflight()
    {
        // Get requested method
        $this->method = strtoupper($this->input->server('REQUEST_METHOD'));

        // Validate the request headers
        if (strtoupper($this->method) === "OPTIONS") {
            //Handle CORS preflight, preflight request is using 'OPTION' method.
            // TODO: should verify this preflight header
            // Set response status code
            $this->output->set_status_header(200);
            // Allow all origin
            // $this->set_header(array('Access-Control-Allow-Origin', 'http://eea258.ee.ust.hk, https://http://eea258.ee.ust.hk, http://i-mos.org, https://i-mos.org'));
            header('Access-Control-Allow-Origin: *');
            // Allow http methods
            header('Access-Control-Allow-Methods: ' . strtoupper(implode(', ', $this->allowed_http_methods)));
            // How long the response to the preflight request can be cached
            header('Access-Control-Max-Age: 3600');
            // Allow custom headers, don't need right now.
            header('Access-Control-Allow-Headers: Authorization');
            // DON'T USE $this->output->set_header('xxx') cuz we use exit.
            exit;
        } elseif (!in_array(strtoupper($this->method), array_map('strtoupper', $this->allowed_http_methods))) {
            // Check the HTTP methods, if not allowed, response 400 not supported.
            $this->exitWithStatus(405);
        }

        // If everything valid, get the token.
        $this->token = $this->input->get_request_header('Authorization', true);

        // Set default header
        $this->contentType = $this->supported_format['json'];
    }

    /**
     * Exit with status code
     *
     * @param type $param
     * @return $value
     *
     * @author Leon
     */
    private function exitWithStatus($status = 400)
    {
        $this->output->set_status_header($status);
        exit;
    }
}
