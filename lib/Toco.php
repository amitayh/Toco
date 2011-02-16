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
     * Add a route to check
     *
     * @param string $pattern
     * @param mixed $match
     * @param array $params
     * @return Toco
     */
    public function route($pattern, $match, $params = array()) {
        $this->_routes[] = array($pattern, $match, $params);
        return $this;
    }
    
    /**
     * Dispatch request
     * 
     * @throws Toco_Exception
     * @return void
     */
    public function run() {
        $request = new Toco_Request();
        $this->_runMiddleware('processRequest', $request);
        $response = null;
        try {
            $match = $this->match($request->path, $this->_routes);
            if ($match === false) {
                throw new Toco_Exception_404("No route matches requested path: $request->path");
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
     * @param array $routes
     * @param array $params
     * @return false|array
     */
    public function match($path, $routes, $params = array()) {
        foreach ($routes as $route) {
            if (!is_array($route) || !isset($route[1])) {
                throw new Toco_Exception('Invalid route: ' . print_r($route, true));
            }
            $pattern = str_replace('/', '\/', $route[0]);
            if (preg_match("/$pattern/", $path, $matches)) {
                /*
                 * Merge all parameters (those that were passed to the method,
                 * from the route and from captured regex matches)
                 */
                if (isset($route[2])) {
                    $params = array_merge($params, $route[2]);
                }
                $params = array_merge($params, $matches);
                if (is_array($route[1])) {
                    // Recursive match
                    $path = preg_replace("/($pattern)/", '', $path);
                    return $this->match($path, $route[1], $params);
                }
                return array($route[1], $params);
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
                    // If the middleware has returned a Toco_Response object, it will dispatch immediately
                    $result->send();
                    exit();
                }
            }
        }
    }

}