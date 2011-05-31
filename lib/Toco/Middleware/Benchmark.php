<?php

/**
 * This middleware is used to test application performance. It will measure the time it took
 * to process the request, from once you instansiate it until you return the response. A special
 * HTTP header will be added to the response with the process time
 * 
 * @package Toco
 */
class Toco_Middleware_Benchmark
{

    protected $_start;

    public function __construct() {
        $this->_start = microtime(true);
    }

    public function processResponse(Toco_Request $request, Toco_Response $response) {
        if ($response->statusCode == 200) {
            $response->headers[] = 'X-Process-Time: ' . round(microtime(true) - $this->_start, 6);
        }
    }

}