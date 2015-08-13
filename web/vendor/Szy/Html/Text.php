<?php

namespace Szy\Html;

class Text extends HtmlElement
{
    public function __construct($content)
    {
        $this->setAttribute(static::ATTR_VALUE, $content);
    }

    public function __toString()
    {
        return "{$this->getAttribute(static::ATTR_VALUE)}";
    }
} 