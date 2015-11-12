<?php

namespace Szy\Http;

class HttpResponse implements Response
{
    /**
     * @var string
     */
    private $headers;

    /**
     * @var array
     */
    private $cookies;

    /**
     * @var string
     */
    private $output;

    /**
     * @param array $headers
     * @param array $cookies
     */
    public function __construct(array $headers, array $cookies = null)
    {
        $this->headers = $headers;
        $this->cookies = $cookies;
    }

    /**
     * @param string $name
     * @return string
     */
    public function getHeader($name)
    {
        return isset($this->headers[$name]) ? $this->headers[$name] : null;
    }

    /**
     * @param string $name
     * @param string $value
     * @param bool $replace
     * @return $this
     */
    public function setHeader($name, $value, $replace = false)
    {
        $this->headers[$name] = $value;
        header("{$name}: {$value}", $replace);
        return $this;
    }

    /**
     * @param int $code
     * @param string|null $message
     * @return $this
     */
    public function setStatus($code, $message = null)
    {
        if (empty($message))
            http_response_code($code);
        else
            header("HTTP/1.1 {$code} {$message}", true, $code);

        return $this;
    }

    /**
     * @param string $url
     * @return void
     */
    public function sendRedirect($url)
    {
        $this->setHeader("Location", $url);
    }

    /**
     * @return string
     */
    public function getContentType()
    {
        return $this->getHeader("Content-Type");
    }

    /**
     * @param string $value
     * @return void
     */
    public function setContentType($value)
    {
        $this->setHeader("Content-Type", $value);
    }

    /**
     * @param mixed $value
     * @return $this
     */
    public function write($value)
    {
        $this->output .= $value;
        return $this;
    }

    /**
     * @param mixed $value
     * @return $this
     */
    public function writeln($value)
    {
        $this->write($value);
        $this->write(PHP_EOL);
        return $this;
    }

    /**
     * @param string $name
     * @return Cookie
     */
    public function getCookie($name)
    {
        $cookie = filter_input(INPUT_COOKIE, FILTER_UNSAFE_RAW);
        if ($cookie)
            return new Cookie($name, $cookie);

        return null;
    }

    /**
     * @param Cookie $cookie
     * @return void
     */
    public function addCookie(Cookie $cookie)
    {
        setcookie($cookie->getName(), $cookie->getValue(), $cookie->getExpires(), $cookie->getPath(), $cookie->getDomain(), $cookie->isSecure(), $cookie->isHttpOnly());
        $this->cookies[$cookie->getName()] = $cookie->getValue();
    }

    /**
     * Clean the response content
     */
    public function clean()
    {
        $this->output = "";
    }

    /**
     * Send content to browser
     */
    public function flush()
    {
        echo $this->__toString();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return strval($this->output);
    }
}