<?php

namespace Szy\Http;

interface Server
{
    /**
     * @return string
     */
    public function getAddress();

    /**
     * @return string
     */
    public function getHost();

    /**
     * @return int
     */
    public function getPort();

    /**
     * @return string
     */
    public function getProtocol();

    /**
     * @return string
     */
    public function getPath();

    /**
     * @param string $name
     * @return string
     */
    public function getParameter($name);
}