<?php

namespace Szy\Mvc\Controller;

use Szy\Http\Request;
use Szy\Http\Response;
use Szy\Mvc\View\View;

interface Controller
{
    /**
     * @return void
     */
    public function init();

    /**
     * @return View
     */
    public function indexAction();

    /**
     * @param string $name
     * @param array $arguments
     * @return View
     */
    public function errorAction($name, array $arguments);

    /**
     * @return Request
     */
    public function getRequest();

    /**
     * @return Response
     */
    public function getResponse();
}