<?php

namespace FastFood\Helper;

class EmptyValidator extends RegexValidator
{
    public function __construct($message)
    {
        parent::__construct('/.*/', $message);
    }

    public function valid($value)
    {
        if (empty($value))
            return false;

        return true;
    }
}