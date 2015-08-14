<?php

namespace Szy\Util;

use Szy\Mvc\Application;

class Date extends \DateTime
{
    /**
     * @param string $time
     */
    public function __construct($time = 'now')
    {
        parent::__construct($time, new \DateTimeZone(Application::getConfig('time_zone')));
    }

    /**
     * @param string $format
     * @param string $time
     * @return DateTime
     */
    public static function createFromFormat($format, $time)
    {
        $date = parent::createFromFormat($format, $time);
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