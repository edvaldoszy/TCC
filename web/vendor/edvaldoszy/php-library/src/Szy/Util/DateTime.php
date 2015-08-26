<?php

namespace Szy\Util;

use Szy\Mvc\Application;

class DateTime extends \DateTime
{
    /**
     * @param string $time
     */
    public function __construct($time = "now")
    {
        $timezone = Application::getConfig("time_zone");
        parent::__construct($time, new \DateTimeZone($timezone));
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->format("d/m/Y");
    }

    /**
     * @return string
     */
    public function toSqlDate()
    {
        return $this->format("Y-m-d");
    }
}