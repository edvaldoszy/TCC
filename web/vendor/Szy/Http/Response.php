<?php

namespace Szy\Http;

class Response
{
    /**
     * @var string
     */
    private $headers;

    /**
     * @var string
     */
    private $output;

    /**
     * @param string $name
     * @param string $value
     * @param bool $replace
     */
    public function setHeader($name, $value, $replace = false)
    {
        $this->headers[$name] = $value;
        header("{$name}: {$value}", $replace);
    }

    /**
     * @param $value
     */
    public function write($value)
    {
        $this->output .= $value;
    }

    /**
     * @param $value
     */
    public function writeln($value)
    {
        $this->write($value);
        $this->write(PHP_EOL);
    }

    public function clean()
    {
        $this->output = "";
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return strval($this->output);
    }
}