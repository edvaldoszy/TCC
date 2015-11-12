<?php

namespace Szy\Http;

class HttpRequest implements Request
{
    /**
     * @var Server
     */
    private $server;

    /**
     * @var array
     */
    private $headers;

    /**
     * @var array
     */
    private $parameters;

    /**
     * @var array
     */
    private $post;

    /**
     * @var HttpSession
     */
    private $session;

    /**
     * @param Server $server
     * @param array $headers
     * @param array $parameters
     * @param array $post
     */
    public function __construct(Server $server, array $headers, array $parameters, array $post)
    {
        if (!$server instanceof Server)
            throw new \InvalidArgumentException("Server can't be null");

        $this->server = $server;
        $this->headers = getallheaders();
        $this->parameters = $parameters;
        $this->post = $post;
        $this->session = new HttpSession();
    }

    /**
     * @param string $name
     * @return string
     */
    public function getHeader($name)
    {
        return isset($this->headers[$name]) ? $this->headers[$name] : null;
    }

    /**
     * @return string
     */
    public function getRemoteAddress()
    {
        return $this->server->getParameter("REMOTE_ADDR");
    }

    /**
     * @return string
     */
    public function getRemoteHost()
    {
        return $this->server->getParameter("REMOTE_HOST");
    }

    /**
     * @return int
     */
    public function getRemotePort()
    {
        return intval($this->server->getParameter("REMOTE_PORT"));
    }

    /**
     * @return bool
     */
    public function isSecure()
    {
        return boolval($this->server->getParameter("SERVER_SCHEME") === "https");
    }

    /**
     * @return string
     */
    public function getContentType()
    {
        return $this->getHeader("Accept");
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->server->getParameter("REQUEST_METHOD");
    }

    /**
     * @param string $name
     * @return Cookie
     */
    public function getCookie($name)
    {
        $cookie = filter_input(INPUT_COOKIE, $name, FILTER_UNSAFE_RAW);
        if ($cookie)
            return new Cookie($name, $cookie);

        return null;
    }

    /**
     * @return HttpSession
     */
    public function getSession()
    {
        if (!$this->session->valid())
            $this->session->start();

        return $this->session;
    }

    /**
     * @param string $name
     * @param int $filter
     * @return mixed
     */
    public function getParam($name, $filter = FILTER_UNSAFE_RAW)
    {
        return filter_input(INPUT_GET, $name, $filter);
    }

    /**
     * @param string $name
     * @param int $filter
     * @return mixed
     */
    public function getPost($name, $filter = FILTER_UNSAFE_RAW)
    {
        return filter_input(INPUT_POST, $name, $filter);
    }
}