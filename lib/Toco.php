<?php

/**
 * Main Toco class
 *
 * @package Toco
 */
class Toco
{

    /**
     * @var array
     */
    protected $_middlewares = array();

    /**
     * @var array
     */
    protected $_routes = array();

    /**
     * @var Toco
     */
    protected static $_instance;

    /**
     * Prevent singleton cloning
     */
    public function  __clone() {
        throw new Toco_Exception('Unable to clone singleton instance of Toco');
    }

    /**
     * Get singleton instance of Toco
     *
     * @return Toco
     */
    public static function getInstance() {
        if (!self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Add a middleware
     * 
     * @param mixed $middleware
     * @return Toco
     */
    public function addMiddleware($middleware) {
        $this->_middlewares[] = $middleware;
        return $this;
    }

    /**
     * Define a route
     *
     * @param Toco_Route $route
     * @param callable $view
     * @return Toco
     */
    public function route(Toco_Route $route, $view) {
        $this->_routes[] = array($route, $view);
        return $this;
    }

    /**
     * Dispatch request
     *
     * @param Toco_Request $request
     * @return void
     */
    public function run(Toco_Request $request) {
        $this->_runMiddleware('processRequest', $request);
        try {
            $match = $this->match($request->path);
            if ($match === false) {
                throw new Toco_Exception_404('No route matches requested path: ' . $request->path);
            }
            list($view, $params) = $match;
            $this->_runMiddleware('processView', $request, $view, $params);
            if (!is_callable($view)) {
                throw new Toco_Exception("View function '$view' is not callable");
            }
            $response = call_user_func($view, $request, $params);
            if (!$response instanceof Toco_Response) {
                throw new Toco_Exception('View function must return a Toco_Response object');
            }
        } catch (Exception $exception) {
            $this->_runMiddleware('processException', $request, $exception);
            // Return a 500 page if an exception was thrown during view processing
            $response = new Toco_Response_500();
        }
        $this->_runMiddleware('processResponse', $request, $response);

        // Send response
        $response->send();
        exit();
    }

    /**
     * Match path to routes
     *
     * @param string $path
     */
    public function match($path) {
        foreach ($this->_routes as $route) {
            list($route, $view) = $route;
            /** @var $route Toco_Route */
            if (($params = $route->match($path)) !== false) {
                return array($view, $params);
            }
        }
        return false;
    }

    /**
     * Run middleware method
     *
     * @param string $method
     * @param Toco_Request $request
     * @param mixed $arg1
     * @param mixed $arg2
     * @return void
     */
    protected function _runMiddleware($method, Toco_Request $request, &$arg1 = null, &$arg2 = null) {
        foreach ($this->_middlewares as $middleware) {
            if (method_exists($middleware, $method)) {
                // Call the method
                $result = $middleware->$method($request, $arg1, $arg2);
                if ($result instanceof Toco_Response) {
                    /** @var $result Toco_Response */
                    
                    // If the middleware has returned a Toco_Response object, it will dispatch immediately
                    $result->send();
                    exit();
                }
            }
        }
    }

}