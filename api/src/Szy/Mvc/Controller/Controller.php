<?php

namespace Szy\Mvc\Controller;

use Szy\Http\Request;
use Szy\Http\Response;
use Szy\Mvc\View\View;

interface Controller
{
    const METHOD_GET = 'GET';

    const METHOD_POST = 'POST';

    const METHOD_PUT = 'PUT';

    const METHOD_DELETE = 'DELETE';

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
     * @param string $method
     * @return boolean
     */
    public function isMethod($method);

    /**
     * @return Request
     */
    public function getRequest();

    /**
     * @return Response
     */
    public function getResponse();
}