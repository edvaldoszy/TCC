<?php

namespace Szy\Session;

class Storage
{
    /**
     * @var array
     */
    private $session;

    /**
     * @param string $cookie
     */
    public function __construct($cookie = 'PHPSESSID')
    {
        if (!isset($_SESSION)) {
            session_start();
            session_name($cookie);
        }
        $this->session = $_SESSION;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function exists($name)
    {
        return isset($this->session[$name]);
    }

    /**
     * @param string $name
     * @param mixed $value
     * @return $this
     */
    public function write($name, $value)
    {
        $this->session[$name] = $value;
        return $this->update();
    }

    /**
     * @param string $name
     * @return mixed|null
     */
    public function read($name)
    {
        return isset($this->session[$name]) ? $this->session[$name] : null;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function delete($name)
    {
        unset($this->session[$name]);
        return $this->update();
    }

    /**
     * @return $this
     */
    private function update()
    {
        $_SESSION = (array) $this->session;
        return $this;
    }

    /**
     * Update session information
     */
    public function __destruct()
    {
        $this->update();
    }
}