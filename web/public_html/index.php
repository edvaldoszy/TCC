<?php

/**
 * PHP does not show errors
 */
ini_set("display_errors", "on");

/**
 * Require Composer autoload file
 */
require_once "../vendor/autoload.php";

use Szy\Mvc\Application;
use Szy\Mvc\Route;

define('BASE_PATH', dirname(__DIR__));
define('PUBLIC_PATH', BASE_PATH . '/public_html');

/**
 * Change current directory
 */
chdir(BASE_PATH);

/**
 * Init application configurations
 */
$app = Application::init(require_once(BASE_PATH . "/config/application.config.php"));

/**
 * Application routes
 */
$route = new Route(require_once(BASE_PATH . "/config/routes.config.php"));

/**
 * Run application
 */
$app->run($route);