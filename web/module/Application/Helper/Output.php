<?php

namespace Application\Helper;

class Output
{
    const STATUS_OK = "OK";

    const STATUS_ERR = "ERR";

    public $status;

    public $message;

    public $data;

    /**
     * @param string $status
     */
    function __construct($status = null)
    {
        $this->status = $status;
    }


    /**
     * @return string
     */
    public function __toString()
    {
        return json_encode($this);
    }
}