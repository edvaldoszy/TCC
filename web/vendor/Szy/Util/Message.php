<?php

namespace Szy\Util;

class Message
{
    const MSG_WARNING = "message-warning";

    const MSG_INFO = "message-info";

    const MSG_ERROR = "message-error";

    const MSG_SUCCESS = "message-success";

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
    public function __construct($text, $type = self::MSG_INFO)
    {
        $this->text = $text;
        $this->type = $type;
    }

    public function __toString()
    {
        return "<div class=\"message {$this->type}\">{$this->text}</div>";
    }
}