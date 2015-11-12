<?php

namespace Szy\Mvc;

class Route
{
    /**
     * @var string
     */
    private $controller;

    /**
     * @var string
     */
    private $action;

    /**
     * @var array
     */
    private $parameters = array();

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->controller = $config["default_controller"];
        $this->action = 'index';
        $this->run($config);
    }

	/**
     * @param array $config
     */
    private function run($config)
    {
        $url = '/' . rtrim(filter_input(INPUT_GET, "url", FILTER_SANITIZE_URL), '/');
        unset($_GET["url"], $_REQUEST["url"]);

        foreach ($config as $k => $v) {
            $pattern = $this->pattern($k);
            //var_dump($pattern);
            if (preg_match("#^{$pattern}/?$#i", $url, $vars)) {
                array_shift($vars);
                $this->controller = $v["controller"];
                $this->action = $v["action"];
                $this->parameters = $vars;
                break;
            }
        }
    }

    /**
     * @param string $str
     * @return string
     */
    private function pattern($str)
    {
        $pattern = array(
            '/\{num\}/' => '([0-9]+)',
            '/\{any\}/' => '(.*)',
            '/\{[a-z]+\}/' => '([a-z]+)'
        );

        return preg_replace(array_keys($pattern), $pattern, $str);
    }

    /**
     * @return string
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return "{$this->action}Action";
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }
}