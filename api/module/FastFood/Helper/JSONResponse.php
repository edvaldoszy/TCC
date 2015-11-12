<?php

namespace FastFood\Helper;

use Szy\Mvc\Controller\Controller;

class JSONResponse
{
    /**
     * @var
     */
    private $controller;

    /**
     * @var array
     */
    private $output;

    /**
     * @param Controller $controller
     */
    public function __construct(Controller $controller)
    {
        $this->controller = $controller;
    }

    /**
     * @param string $name
     * @param mixed $value
     */
    public function set($name, $value)
    {
        $this->output[$name] = $value;
    }

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->set('message', $message);
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->set('data', $data);
    }

    /**
     * @param bool $pretty
     */
    public function flush($pretty = false)
    {
        $this->controller->getResponse()->setContentType('application/json; charset=utf-8');
        $this->controller->getResponse()->write(json_encode($this->output, $pretty));
    }
}