<?php

namespace Application\Helper;

class EmptyValidator extends RegexValidator
{
    public function __construct($pattern, $message)
    {
        parent::__construct("", $message);
    }

    public function valid($value)
    {
        if (empty($value))
            return false;

        return true;
    }
}