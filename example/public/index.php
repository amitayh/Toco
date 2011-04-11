<?php

require '../app/common.php';

// Setup Toco
$toco = Toco::getInstance();

// Add middlewares
if (DEBUG) {
    $toco->addMiddleware(new Toco_Middleware_Benchmark());
}
$toco->addMiddleware(new Toco_Middleware_Common())
     ->addMiddleware(new Toco_Middleware_Gzip());

// Define application routes
require APPLICATION_PATH . '/urls.php';

// Define application view functions
require APPLICATION_PATH . '/views.php';

// Dispatch the request
$toco->run();