<?php

namespace Application\Helper;

class EmailValidator extends RegexValidator
{
    /**
     * @param string $message
     */
    public function __construct($message)
    {
        parent::__construct('/\w+@\w+\.\w{2,3}(\.[a-zA-Z]{2})?/i', $message);
    }

}