<?php

namespace Szy\Mvc\Controller;

use FastFood\Helper\PostField;
use Szy\Http\HttpSession;
use Szy\Http\Request;
use Szy\Http\Response;
use Szy\Mvc\Application;
use Szy\Mvc\Model\Model;
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
     * @var array
     */
    private $models = array();

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
     * @return boolean
     */
    public function isMethod($method)
    {
        return $this->request->getMethod() == $method;
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

    /**
     * @param string $name
     * @return Model
     */
    public function model($name)
    {
        $model = Application::getConfig('model');
        if (!isset($this->models[$name]) || $this->models[$name] == null) {
            $rc = new \ReflectionClass($model[$name]);
            $this->models[$name] = $rc->newInstance();
        }

        return $this->models[$name];
    }

    /**
     * @return HttpSession
     */
    public function getSession()
    {
        return $this->getRequest()->getSession();
    }

    /**
     * @param string $name
     * @param int $filter
     * @return mixed
     */
    public function getPost($name, $filter = FILTER_UNSAFE_RAW)
    {
        return $this->getRequest()->getPost($name, $filter);
    }

    /**
     * @param string $name
     * @return PostField
     */
    public function getPostField($name)
    {
        return new PostField($name);
    }

    /**
     * @param string $name
     * @param int $filter
     * @return mixed
     */
    public function getParam($name, $filter = FILTER_UNSAFE_RAW)
    {
        return $this->getRequest()->getParam($name, $filter);
    }
}