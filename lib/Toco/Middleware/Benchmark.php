<?php

/**
 * This middleware is used to test application performance. It will measure the time it took
 * to process the request, from once you instansiate it until you return the response. If response
 * is an HTML page, it will add process time as a comment to the end of the response
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
        if ($response->statusCode == 200 && $response->contentType == 'text/html') {
            $response->content .= '<!-- ' . round(microtime(true) - $this->_start, 6) . ' -->';
        }
    }

}