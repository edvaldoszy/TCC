<?php

namespace Szy\Mvc\View;

interface View
{
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