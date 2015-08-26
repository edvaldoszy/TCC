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

    private function run($config)
    {
        $uri = rtrim(filter_input(INPUT_GET, "REQUEST_URI", FILTER_SANITIZE_URL), '/');
        if (empty($uri)) $uri = '/';
        unset($_GET["REQUEST_URI"], $_REQUEST["REQUEST_URI"]);

        foreach ($config as $k => $v) {
            $pattern = $this->pattern($k);
            if (preg_match("#^{$pattern}/?(.*)#i", $uri, $vars)) {
                unset($vars[0]);
                if (isset($vars[1]))
                    $vars = explode('/', ltrim($vars[1], '/'));

                if (isset($v["controller"][1]))
                    $this->controller = $v["controller"];

                if (isset($v["action"][1]))
                    $this->action = $v["action"];
                else if (isset($vars[0][1])) {
                    $this->action = $vars[0];
                    unset($vars[0]);
                }

                $this->parameters = array_values($vars);
                break;
            }
        }

        //var_dump($this->getController(), $this->getAction());
    }

    /**
     * @param string $str
     * @return string
     */
    private function pattern($str)
    {
        $pattern = array(
            '/\{num\}/' => '([^/?][0-9]+)',
            '/\{any\}/' => '(.*)',
            '/\{[a-z]+\}/' => '([^/?][a-z]+)'
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