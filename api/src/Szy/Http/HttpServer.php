<?php

namespace Szy\Http;

final class HttpServer implements Server
{
    /**
     * @var array
     */
    private $parameters;

    /**
     * @param array $parameters
     */
    public function __construct(array $parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->getParameter("SERVER_ADDR");
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->getParameter("SERVER_NAME");
    }

    /**
     * @return int
     */
    public function getPort()
    {
        return $this->getParameter("SERVER_PORT");
    }

    /**
     * @return string
     */
    public function getProtocol()
    {
        return $this->getParameter("SERVER_PROTOCOL");
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->getParameter("PATH");
    }

    /**
     * @param string $name
     * @return string
     */
    public function getParameter($name)
    {
        return isset($this->parameters[$name]) ? $this->parameters[$name] : null;
    }
}