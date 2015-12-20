<?php

/**
 * PHP does not show errors
 */
ini_set("display_errors", (isset($_GET['debug']) ? 'on' : 'off'));

/**
 * Require Composer autoload file
 */
require_once "vendor/autoload.php";

use Szy\Mvc\Application;
use Szy\Mvc\Route;

define('BASE_PATH', __DIR__);
define('PUBLIC_PATH', BASE_PATH);
define('BASE_SYSTEM_PATH', dirname(BASE_PATH));

/**
 * Change current directory
 */
//chdir(BASE_PATH);

/**
 * Init application configurations
 */
$app = Application::init(require_once("config/application.config.php"));

/**
 * Application routes
 */
$route = new Route(require_once("config/routes.config.php"));

/**
 * Run application
 */
$app->run($route);