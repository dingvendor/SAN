<?php

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(dirname(__FILE__)) . '/application'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Ensure library/ is on include_path
set_include_path(
    APPLICATION_PATH
    . PATH_SEPARATOR
    . APPLICATION_PATH . '/../library'
    . PATH_SEPARATOR
    . get_include_path());

/** Zend_Application */
require_once 'Zend/Application.php';

// Custom functions to help development
require_once ('Utils.php');

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);
$application->bootstrap()
            ->run();
