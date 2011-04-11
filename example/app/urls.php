<?php

// Homepage route
$toco->route(new Toco_Route('/'), 'index');

// Default route
$toco->route(new Toco_Route('/:controller/:action', array('action' => 'index')), 'defaultView');