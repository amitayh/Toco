<?php

/**
 * @package Toco
 */
abstract class Toco_Controller
{

    /**
     * The request object
     *
     * @var Toco_Request
     */
    protected $_request;

    /**
     * Parameters passed to view
     *
     * @var array
     */
    protected $_params;

    /**
     * Template variables
     * 
     * @var array
     */
    protected $_vars;

    /**
     * Constructor
     *
     * @param Toco_Request $request
     * @param array $params
     * @param array $vars
     */
    public function __construct(Toco_Request $request, $params = array(), $vars = array()) {
        $this->_request = $request;
        $this->_params = $params;
        $this->_vars = $vars;
    }

    /**
     * Check if controller action exists, otherwise throw a 404 exception
     * 
     * @throws Toco_Exception_404
     * @param string $method
     * @param array $args
     * @return void
     */
    public function __call($method, $args) {
        if (substr($method, -6) == 'Action') {
            $controllerClass = get_class($this);
            throw new Toco_Exception_404("Controller action '$controllerClass::$method' does not exist");
        }
    }

    /**
     * Set a template variable
     *
     * @param string $key
     * @param mixed $value
     * @return Toco_Controller
     */
    public function setVar($key, $value) {
        $this->_vars[$key] = $value;
        return $this;
    }

    /**
     * Execute a controller action
     *
     * @param string $action
     * @return Toco_Response
     */
    public function renderToResponse($action) {
        $method = $action . 'Action';
        $result = $this->$method();
        if ($result instanceof Toco_Response) {
            return $result;
        }
        return Toco_Response::renderToResponse($this->getTemplate($action), $this->_vars);
    }

    /**
     * Get template file for action
     * 
     * @param string $action
     * @return string
     */
    public function getTemplate($action) {
        $controller = $this->getName();
        return "$controller/$action.html";
    }

    /**
     * Get controller name
     *
     * @return string
     */
    abstract function getName();

}