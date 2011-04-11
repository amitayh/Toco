<?php

// Homepage route
$toco->route(new Toco_Route('/'), 'index');

// Blog
$toco->route(new Toco_Route('/blog/:year/:month/:slug'), 'blogArticle');
$toco->route(new Toco_Route('/blog/:year/:month'), 'blogArchiveMonth');
$toco->route(new Toco_Route('/blog/:year'), 'blogArchiveYear');
$toco->route(new Toco_Route('/blog/:page', array('page' => '1')), 'blogIndex');

// Default route
$toco->route(new Toco_Route('/:controller/:action', array('action' => 'index')), 'defaultView');