<?php

namespace FastFood\Helper;

class PhoneValidator extends RegexValidator
{
    /**
     * @param string $message
     */
    public function __construct($message)
    {
        parent::__construct('/\(\d{2,3}\)\s?\d{4,5}\-\d{4}/', $message);
    }

}