<?php

namespace Szy\Mvc\Controller;

use Szy\Session\Storage as SessionStorage;

abstract class AbstractController implements Controller
{
    /**
     * Get method
     */
    const METHOD_GET = 'GET';

    /**
     * Post method
     */
    const METHOD_POST = 'POST';

    /**
     * Delete method
     */
    const METHOD_DELETE = 'DELETE';

    /**
     * Put method
     */
    const METHOD_PUT = 'PUT';

    /**
     * @var SessionStorage
     */
    private static $session;

    /**
     * @return void
     */
    public function init() {}

    /**
     * @return SessionStorage
     */
    public function getSession()
    {
        if (null == self::$session)
            self::$session = new SessionStorage();

        return self::$session;
    }

    /**
     * Returns a server parameter
     *
     * @param string $name
     * @param int $filter
     * @return mixed
     */
    public function getServerParam($name, $filter = FILTER_UNSAFE_RAW)
    {
        return filter_input(INPUT_SERVER, $name, $filter);
    }

    /**
     * @param string $method
     * @return bool
     */
    private function isMethod($method)
    {
        return $this->getServerParam('REQUEST_METHOD') === $method;
    }

    /**
     * @return bool
     */
    public function isPost()
    {
        return $this->isMethod(self::METHOD_POST);
    }

    /**
     * Returns a post parameter
     *
     * @param string $name
     * @param int $filter
     * @return mixed
     */
    public function getPost($name, $filter = FILTER_UNSAFE_RAW)
    {
        return filter_input(INPUT_POST, $name, $filter);
    }

    /**
     * Returns a get parameter
     *
     * @param string $name
     * @param int $filter
     * @return mixed
     */
    public function getParam($name, $filter = FILTER_UNSAFE_RAW)
    {
        return filter_input(INPUT_GET, $name, $filter);
    }

    /**
     * @param array $prm
     * @return string
     */
    public function getQueryString(array $prm)
    {
        $get = $_GET;
        foreach ($prm as $k)
            if (isset($get[$k]))
                $out[] = "{$k}={$get[$k]}";

        return isset($out) ? implode("&", $out) : "";
    }

    /**
     * Redirect the page
     * @param string $url
     */
    public function redirect($url)
    {
        header("location: {$url}");
        exit;
    }

    public function __call($name, $arguments) {
        return "<h1>Page Not Found</h1>";
    }
} 