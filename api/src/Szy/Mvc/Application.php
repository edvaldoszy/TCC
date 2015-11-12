<?php

namespace Szy\Mvc;

use Szy\Http\HttpRequest;
use Szy\Http\HttpResponse;
use Szy\Http\HttpServer;
use Szy\Http\Request;
use Szy\Http\Response;
use Szy\Http\Server;
use Szy\Mvc\Controller\Controller;

class Application implements Container
{
    /**
     * @var array
     */
    private static $config;

    /**
     * @var Server
     */
    private $server;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var Response
     */
    private $response;

    /**
     * @param array $config
     */
    private function __construct(array $config)
    {
        self::$config = $config;

        $this->server = new HttpServer($_SERVER);
        $this->request = new HttpRequest($this->server, getallheaders(), $_GET, $_POST);
        $this->response = new HttpResponse(headers_list(), $_COOKIE);
    }

    /**
     * Run the application
     * @param Route $route
     */
    public function run(Route $route)
    {
        try {
            $rc = new \ReflectionClass($route->getController());
            /** @var Controller $controller */
            $controller = $rc->newInstance($this->request, $this->response);
            $controller->init();
            call_user_func_array(array($controller, $route->getAction()), $route->getParameters());
        } catch (\ReflectionException $ex) {
            $this->response->setStatus(Response::STATUS_NOT_FOUND);
            $this->response->write($ex->getMessage());
        }
        exit($this->response);
    }

    /**
     * @param string $name
     * @return string
     */
    public static function getConfig($name)
    {
        return isset(self::$config[$name]) ? self::$config[$name] : null;
    }

    /**
     * @param array $config
     * @return Application
     */
    public static function init(array $config)
    {
        $self = new self($config);
        return $self;
    }
}