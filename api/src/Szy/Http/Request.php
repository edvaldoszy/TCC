<?php

namespace Szy\Http;

interface Request
{
    /**
     * Request GET method
     */
    const METHOD_GET = "GET";

    /**
     * Request POST method
     */
    const METHOD_POST = "POST";

    /**
     * Request PUT method
     */
    const METHOD_PUT = "PUT";

    /**
     * Request DELETE method
     */
    const METHOD_DELETE = "DELETE";

    /**
     * @param string $name
     * @return string
     */
    public function getHeader($name);

    /**
     * @return string
     */
    public function getRemoteAddress();

    /**
     * @return string
     */
    public function getRemoteHost();

    /**
     * @return int
     */
    public function getRemotePort();

    /**
     * @return bool
     */
    public function isSecure();

    /**
     * @return string
     */
    public function getContentType();

    /**
     * @return string
     */
    public function getMethod();

    /**
     * @param string $name
     * @return Cookie
     */
    public function getCookie($name);

    /**
     * @return HttpSession
     */
    public function getSession();

    /**
     * @param string $name
     * @param int $filter
     * @return mixed
     */
    public function getParam($name, $filter = FILTER_UNSAFE_RAW);

    /**
     * @param string $name
     * @param int $filter
     * @return mixed
     */
    public function getPost($name, $filter = FILTER_UNSAFE_RAW);
}