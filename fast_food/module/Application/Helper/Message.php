<?php

namespace Application\Helper;

class Message
{
    const TYPE_INFO = 'callout-info';
    const TYPE_DANGER = 'callout-danger';
    const TYPE_SUCCESS = 'callout-success';
    const TYPE_WARNING = 'callout-warning';

    /**
     * @var string
     */
    private $text;

    /**
     * @var string
     */
    private $type;

    /**
     * @param string $text
     * @param string $type
     */
    public function __construct($text, $type = self::TYPE_INFO)
    {
        $this->text = $text;
        $this->type = $type;
    }

    public function __toString()
    {
        return sprintf('<div class="callout %s"><p>%s</p></div>', $this->type, $this->text);
    }
}