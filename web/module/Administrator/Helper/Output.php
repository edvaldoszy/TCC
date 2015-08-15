<?php

namespace Administrator\Helper;

use Szy\Mvc\Helper\AbstractHelper;

class Output extends AbstractHelper
{
    /**
     * @var string
     */
    public $status;

    /**
     * @var string
     */
    public $message;

    /**
     * @var mixed
     */
    public $data;

    /**
     * @return string
     */
    public function __toString()
    {
        return json_encode($this);
    }
}