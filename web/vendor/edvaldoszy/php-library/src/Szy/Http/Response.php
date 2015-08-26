<?php

namespace Szy\Http;

interface Response
{
    const STATUS_NOT_FOUND = 404;

    /**
     * @param string $name
     * @return string
     */
    public function getHeader($name);

    /**
     * @param string $name
     * @param string $value
     * @return $this
     */
    public function setHeader($name, $value);

    /**
     * @param int $code
     * @return $this
     */
    public function setStatus($code);

    /**
     * @param string $url
     * @return void
     */
    public function sendRedirect($url);

    /**
     * @return string
     */
    public function getContentType();

    /**
     * @param string $value
     * @return void
     */
    public function setContentType($value);

    /**
     * @param mixed $value
     * @return $this
     */
    public function write($value);

    /**
     * @param mixed $value
     * @return $this
     */
    public function writeln($value);

    /**
     * @param string $name
     * @return Cookie
     */
    public function getCookie($name);

    /**
     * @param Cookie $cookie
     * @return void
     */
    public function addCookie(Cookie $cookie);

    /**
     * Clean the response content
     *
     * @return void
     */
    public function clean();

    /**
     * Send content to browser
     *
     * @return void
     */
    public function flush();

    /**
     * @return string
     */
    public function __toString();
}