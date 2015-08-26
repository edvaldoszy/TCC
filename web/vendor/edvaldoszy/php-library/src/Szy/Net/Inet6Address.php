<?php

namespace Szy\Net;

class Inet6Address implements InetAddress
{
    /**
     * @param string $address
     */
    public function __construct($address)
    {
        throw new \InvalidArgumentException("Unsupported operation");
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        // TODO: Implement getAddress() method.
    }

    /**
     * @return int
     */
    public function getMask()
    {
        // TODO: Implement getMask() method.
    }

    /**
     * @return mixed
     */
    public function __toString()
    {
        // TODO: Implement __toString() method.
    }
}