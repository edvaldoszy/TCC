<?php

namespace BLZ\Util;

use Szy\Mvc\Application;

class DateTime extends \DateTime
{
    /**
     * @param string $time
     */
    public function __construct($time = "now")
    {
        $config = Application::getConfig("time_zone");
        parent::__construct($time, new \DateTimeZone($config["time_zone"]));
    }

    public static function createFromFormat($format, $time)
    {
        $date = \DateTime::createFromFormat($format, $time);
        return new self($date->format("Y-m-d"));
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