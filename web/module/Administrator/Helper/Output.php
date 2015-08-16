<?php

namespace Administrator\Helper;

use Szy\Mvc\Helper\AbstractHelper;

class Output extends AbstractHelper
{
    /**
     * OK code
     */
    const CODE_OK = 1;

    /**
     * Error code
     */
    const CODE_ERR = 0;

    /**
     * @var int
     */
    public $code = 0;

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