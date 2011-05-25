<?php

// General config
define('DEBUG', true);
define('APPLICATION_PATH', dirname(__FILE__));
define('TEMPLATES_PATH', APPLICATION_PATH . '/templates');
define('CACHE_PATH', APPLICATION_PATH . '/cache');
define('TEMPLATE_ADAPTER', 'Toco_Template_Adapter_Twig');
define('BASE_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/~amitay/toco/example/public/');
define('MEDIA_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/~amitay/toco/example/public/');