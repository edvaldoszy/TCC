<?php

namespace Application\Helper;

use Szy\Util\Regex\Pattern;

class RegexValidator
{
    /**
     * @var Pattern
     */
    protected $pattern;

    /**
     * @var string
     */
    protected $message;

    /**
     * @param Pattern|string $pattern
     * @param string $message
     */
    public function __construct($pattern, $message)
    {
        $this->pattern = $pattern instanceof Pattern ? $pattern : new Pattern($pattern);
        $this->message = $message;
    }

    /**
     * @param mixed $value
     * @return bool
     */
    public function valid($value)
    {
        $value = trim($value);
        if ($value == '')
            return false;

        return $this->pattern->match($value);
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }
}