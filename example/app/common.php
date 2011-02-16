<?php

// Load config file
require 'config.php';

// Set error reporting
error_reporting((DEBUG) ? E_ALL : 0);

// Setup autoloader
$includePath = array(
    get_include_path(),
    APPLICATION_PATH,
    realpath(APPLICATION_PATH . '/../../lib'),
    realpath(APPLICATION_PATH . '/../../lib/Twig/lib')
);
set_include_path(implode(PATH_SEPARATOR, $includePath));
spl_autoload_register('autoload');
function autoload($class) {
    $className = str_replace('_', '/', $class);
    @include $className . '.php';
}