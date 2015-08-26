<?php

namespace Szy\Mvc\Controller;

use Szy\Http\Request;
use Szy\Http\Response;
use Szy\Mvc\View\View;

abstract class AbstractController implements Controller
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Response
     */
    protected $response;

    /**
     * @param Request $request
     * @param Response $response
     */
    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * @return void
     */
    public function init() {}

    /**
     * @param string $name
     * @param array $arguments
     * @return View
     */
    public function errorAction($name, array $arguments)
    {
        $this->response->setStatus(Response::STATUS_NOT_FOUND);
        $this->response->write("Method ({$name}) does not exist");
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return void
     */
    public function __call($name, array $arguments)
    {
        $name = str_replace('Action', '', $name);
        $this->errorAction($name, $arguments);
    }

    /**
     * @param string $method
     * @return bool
     */
    public function isMethod($method)
    {
        return $this->request->getMethod() == $method;
    }

    /**
     * @return \Szy\Http\HttpSession
     */
    public function getSession()
    {
        return $this->request->getSession();
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }
}