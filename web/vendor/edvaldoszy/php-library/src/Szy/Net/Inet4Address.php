<?php

namespace Szy\Net;

use Szy\Util\Regex\Pattern;

class Inet4Address implements InetAddress
{
    /**
     * @var string
     */
    private $address;

    /**
     * @param string $address
     */
    public function __construct($address)
    {
        $p = new Pattern('/^([0-9]{1,3}\.){3}[0-9]{1,3}(\/[0-9]{2})?$/');
        if (!$p->match($address))
            throw new \InvalidArgumentException("Invalid IPv4 address");

        $this->address = $address;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        $pos = strpos($this->address, '/');
        return substr($this->address, 0, ($pos ? $pos : strlen($this->address)));
    }

    /**
     * @return string
     */
    public function getMask()
    {
        return intval(substr(strrchr($this->address, '/'), 1));
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->address;
    }
}