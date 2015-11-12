<?php

namespace Szy\Mvc\View;

interface View
{
    /**
     * @param string $name
     * @return mixed
     */
    public function getAttribute($name);

    /**
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public function setAttribute($name, $value);

    /**
     * @return string
     */
    public function getLanguage();

    /**
     * @return string
     */
    public function getCharset();

    /**
     * @return string
     */
    public function getTitle();

    /**
     * @return void
     */
    public function flush();
}