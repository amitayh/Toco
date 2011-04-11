<?php

// Homepage view
function index(Toco_Request $request, $params) {
    return Toco_Response::renderToResponse('index.html', array('menu' => 'home'));
}

// Default view
function defaultView(Toco_Request $request, $params) {
    $controllerName = strtolower($params['controller']);
    $controllerClass = ucfirst($controllerName) . 'Controller';
    if (!class_exists($controllerClass)) {
        throw new Toco_Exception_404("No route matches requested path: $request->path");
    }
    $context = array('menu' => $controllerName);
    $controller = new $controllerClass($request, $params, $context);
    return $controller->renderToResponse(strtolower($params['action']));
}