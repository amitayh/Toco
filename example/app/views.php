<?php

function index(Toco_Request $request, $params) {
    return Toco_Response::renderToResponse('index.html', array('menu' => 'home'));
}