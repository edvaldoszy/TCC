<?php

namespace Szy\Mvc;

use Szy\Mvc\Controller\Controller;

class Application
{
    /**
     * @var Application
     */
    private static $instance;

    /**
     * @var array
     */
    private static $config;

    /**
     * @var string
     */
    private $controller = 'Application\Controller\IndexController';

    /**
     * @var string
     */
    private $action = 'index';

    /**
     * @var array
     */
    private $params = array();

    /**
     * @param array $routes
     */
    public function __construct($routes)
    {
        // If $_GET["_url"] exists return "/url-pattern" and strip slashes from end
        // If $_GET["_url"] doesn't exists return only "/"
        $url = isset($_GET["_url"]) ? rtrim("/{$_GET["_url"]}", '/') : '/';

        foreach ($routes as $k => $v) {
            if (preg_match("#^{$k}(.*)$#", $url, $vars)) {
                if (isset($v['controller'][1])) { $this->controller =  $v['controller']; }
                $prm = isset($vars[1]) ? $vars[1] : ''; unset($vars);
                $prm = explode('/', ltrim($prm, '/'));

                if (isset($v['action'])) {
                    $this->action = $v['action'];
                } else if (isset($prm[0][1])) {
                    $this->action = $prm[0];
                    array_shift($prm);
                }
                $this->params = $prm;
                break;
            }
        }

        $this->run(); // Run the application
    }

    /**
     * Run the application
     */
    public function run()
    {
        $class = $this->controller;
        $action = "{$this->action}Action";

        if (class_exists($class)) {

            /** @var Controller $controller */
            $controller = new $class;
            $controller->init();
            exit(call_user_func_array(array($controller, $action), $this->params));
        } else {
            exit("<h1>Page Not Found</h1>");
        }
    }

    /**
     * @param string $name
     * @return mixed|null
     */
    public static function getConfig($name)
    {
        return isset(self::$config[$name]) ? self::$config[$name] : null;
    }

    /**
     * @param array $routes
     * @param array|null $config
     */
    public static function init($routes, array $config = null)
    {
        if (null == self::$instance)
            self::$instance = new self($routes);

        if (null != $config)
            self::$config = $config;
    }


} 