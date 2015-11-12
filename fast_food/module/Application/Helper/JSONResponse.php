<?php

namespace Application\Helper;

use Szy\Util\JSONEncoder;

class JSONResponse
{
    /**
     * @var string
     */
    private $message;

    /**
     * @var mixed
     */
    private $data;

    /**
     * @return string
     */
    public function __toString()
    {
        $encode = new JSONEncoder();
        return $encode->encode($this);
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }
}