<?php

namespace Szy\Net;

interface InetAddress
{
    /**
     * @return string
     */
    public function getAddress();

    /**
     * @return int
     */
    public function getMask();

    /**
     * @return mixed
     */
    public function __toString();
}