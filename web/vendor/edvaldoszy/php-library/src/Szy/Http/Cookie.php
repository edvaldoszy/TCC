<?php

namespace Szy\Http;

class Cookie
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $value;

    /**
     * @var string
     */
    private $path = "/";

    /**
     * @var string
     */
    private $domain;

    /**
     * @var \DateTime
     */
    private $maxAge;

    /**
     * @var boolean
     */
    private $secure = false;

    /**
     * @var boolean
     */
    private $httpOnly = false;

    /**
     * @param string $name
     * @param string $value
     */
    public function __construct($name, $value)
    {
        $this->name = $name;
        $this->value = $value;
        $this->maxAge = new \DateTime();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return strval($this->name);
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return strval($this->value);
    }

    /**
     * @param string $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return strval($this->path);
    }

    /**
     * @param string $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @return string
     */
    public function getDomain()
    {
        return strval($this->domain);
    }

    /**
     * @param string $domain
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;
    }

    /**
     * @return \DateTime
     */
    public function getMaxAge()
    {
        return $this->maxAge;
    }

    /**
     * @param \DateTime $date
     */
    public function setMaxAge($date)
    {
        $this->maxAge = $date;
    }

    /**
     * @return int
     */
    public function getExpires()
    {
        return $this->maxAge->getTimestamp();
    }

    /**
     * @param int $time
     */
    public function setExpires($time)
    {
        $this->maxAge->setTimestamp($time);
    }

    /**
     * @return boolean
     */
    public function isSecure()
    {
        return $this->secure;
    }

    /**
     * @param boolean $secure
     */
    public function setSecure($secure)
    {
        $this->secure = $secure;
    }

    /**
     * @return boolean
     */
    public function isHttpOnly()
    {
        return $this->httpOnly;
    }

    /**
     * @param boolean $httpOnly
     */
    public function setHttpOnly($httpOnly)
    {
        $this->httpOnly = $httpOnly;
    }
}