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

// Default route
$toco->route('^(?P<controller>[^/]+?)(/(?P<action>[^/]+?))?/$', 'defaultView');

// Default view
function defaultView(Toco_Request $request, $params) {
    $controllerName = strtolower($params['controller']);
    $controllerClass = ucfirst($controllerName) . 'Controller';
    if (!class_exists($controllerClass)) {
        throw new Toco_Exception_404("No route matches requested path: $request->path");
    }
    $context = array('menu' => $controllerName);
    $controller = new $controllerClass($request, $params, $context);
    $action = (isset($params['action'])) ? strtolower($params['action']) : 'index';
    return $controller->renderToResponse($action);
}

// Dispatch the request
$toco->run();