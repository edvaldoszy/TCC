<?php

ini_set('display_errors', 'on');

require_once '../vendor/autoload.php';

use Szy\Mvc\Application;
use Szy\File\FileSystem;

define('BASE_PATH', dirname(__DIR__));
define('PUBLIC_PATH', BASE_PATH . '/public_html');

FileSystem::chdir(BASE_PATH);

Application::init(require_once(BASE_PATH . '/config/routes.config.php'), require_once(BASE_PATH . '/config/application.config.php'));