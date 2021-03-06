<?php

/**
 * Basic HTTP request object
 *
 * @package Toco
 */
class Toco_Request
{

    /**
     * @var array
     */
    public $GET;

    /**
     * @var array
     */
    public $POST;

    /**
     * @var array
     */
    public $FILES;

    /**
     * @var array
     */
    public $COOKIE;

    /**
     * @var array
     */
    public $REQUEST;

    /**
     * @var string
     */
    public $method;

    /**
     * @var string
     */
    public $path = '';

    /**
     * @var array
     */
    public $headers = array();

    /**
     * @var array
     */
    protected $_data = array();

    /**
     * Constructor
     */
    public function __construct() {
        $this->GET = &$_GET;
        $this->POST = &$_POST;
        $this->FILES = &$_FILES;
        $this->COOKIE = &$_COOKIE;
        $this->REQUEST = &$_REQUEST;
        
        $this->method = $_SERVER['REQUEST_METHOD'];
        if (isset($_SERVER['PATH_INFO'])) {
            $this->path = '/' . trim($_SERVER['PATH_INFO'], '/');
        }
        $this->headers = $this->_getHeaders(); 
    }

    /**
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public function __set($name, $value) {
        $this->_data[$name] = $value;
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function __get($name) {
        if (isset($this->_data[$name])) {
            return $this->_data[$name];
        }
        $trace = debug_backtrace();
        trigger_error(
            'Undefined property via __get(): ' . $name .
            ' in ' . $trace[0]['file'] .
            ' on line ' . $trace[0]['line'],
            E_USER_NOTICE
        );
        return null;
    }

    /**
     * @param string $name
     * @return boolean
     */
    public function __isset($name) {
        return isset($this->_data[$name]);
    }

    /**
     * @param string $name
     * @return void
     */
    public function __unset($name) {
        unset($this->_data[$name]);
    }

    public function hasRequestParam($param) {
        return isset($this->REQUEST[$param]);
    }

    public function getRequestParam($param, $default = null) {
        if (isset($this->REQUEST[$param])) {
            return $this->REQUEST[$param];
        }
        return $default;
    }

    /**
     * Try to check if request was made by AJAX call
     *
     * @return boolean
     */
    public function isAjax() {
        return (
            isset($this->headers['HTTP_X_REQUESTED_WITH']) &&
            $this->headers['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'
        );
    }

    /**
     * Extract request headers
     * 
     * @return array
     */
    protected function _getHeaders() {
         $headers = array();
        foreach ($_SERVER as $key => $value) {
            if (substr($key, 0, 5) == 'HTTP_') {
                $headers[$key] = $value;
            }
        }
        return $headers;
    }

}