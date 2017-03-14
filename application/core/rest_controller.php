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
     * List of allowed HTTP status codes
     *
     * @author Leon
     */
    protected $httpStatusCodes = array(
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',

        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        307 => 'Temporary Redirect',

        400 => 'Bad Request',
        401 => 'Unauthorized',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Requested Range Not Satisfiable',
        417 => 'Expectation Failed',

        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported'
    );

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
        $this->load->helper('url');
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
                log_message('error', 'Response error: content body is false.');
            } elseif (is_array($this->body) && is_numeric(key($this->body)) && array_key_exists(key($this->body), $this->httpStatusCodes)) {
                // if body contains http code, such as array(401 => "Invalid password")
                $this->status = key($this->body);
                $this->output->set_output(json_encode(current($this->body)));
            } elseif ($this->body !== null && $this->body !== false) {
                // if nothing goes wrong
                $this->status = 200;
                $this->output->set_output(json_encode($this->body));
            } else {
                $this->status = 500;
                log_message('error', 'Response error: unknown situation for response.');
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
     * Validate string
     *
     * @param request parameter, default value
     * @return string if valid, false if not valid
     *
     * @author Leon
     */
    protected function validateString($param, $default = '')
    {
        // TODO: add RE here to validate string
        if ($param) {
            // escape quotes
            return $param;
        } else {
            return $default;
        }
    }

    private $delete = null;
    /**
     * Handle delete request
     *
     * @param $index
     * @return $delete parameters
     *
     * @author Leon
     */
    protected function delete($index)
    {
        if ($this->delete) {
            return $this->delete[$index];
        } elseif ($this->method === 'DELETE') {
            parse_str(file_get_contents("php://input"), $this->delete);
            return $this->delete[$index];
        } else {
            return false;
        }
    }

    private $put = null;
    /**
     * Handle put request
     *
     * @param $index
     * @return $put parameters
     *
     * @author Leon
     */
    protected function put($index)
    {
        if ($this->put) {
            return $this->put[$index];
        } elseif ($this->method === 'PUT') {
            parse_str(file_get_contents("php://input"), $this->put);
            return $this->put[$index];
        } else {
            return false;
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
        if ($this->method === "OPTIONS") {
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
            header('Access-Control-Allow-Headers: Authorization, Content-Type');
            // DON'T USE $this->output->set_header('xxx') cuz we use exit.
            exit;
        } elseif (!in_array($this->method, array_map('strtoupper', $this->allowed_http_methods))) {
            // Check the HTTP methods, if not allowed, response 400 not supported.
            $this->exitWithStatus(405);
        }

        // If everything valid, get the token.
        $this->token = $this->input->get_request_header('Authorization', true);
        // FIXME: remove this function after new simulation platform
        $this->handleTokenForOldSystem();

        // Set default header
        $this->contentType = $this->supported_format['json'];
    }

    /**
     * Exit with status code
     *
     * @param status
     *
     * @author Leon
     */
    protected function exitWithStatus($status = 400)
    {
        $this->output->set_status_header($status);
        exit;
    }

    /**
     * Handle token for old Simulation Platform system
     *
     * @author Leon
     */
    private function handleTokenForOldSystem()
    {
        // This get is for Simulation Platform iframe
        // FIXME: Here we have potential security issue, exposing token in url
        if (!$this->token) {
            if ($this->method === 'GET' && uri_string() === 'simulation') {
                $this->token = $this->input->get('SimulationAuthorization');
                // For cross-domain situation, token are stores in two different
                // domains, we need to manually handle this for old
                // Simulation Platform system
                $token = array_key_exists("token", $_COOKIE) ? $_COOKIE["token"] : "";
                // If the token cookie is empty, we need to write the token to
                // client browser for other requests to use
                if (!$token && $this->token) {
                    setcookie("token", $this->token, time() + (86400 * 30), "/"); // 86400 = 1 day
                    log_message('TOKEN', 'Writing token to cookie: ' . $this->token);
                }

                log_message('TOKEN', 'Token from simulaiton request: ' . $this->token);
            }
        }
    }
}
