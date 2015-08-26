<?php

namespace Szy\Http;

class HttpSession implements Session
{
    /**
     * @var array
     */
    private $storage;

    /**
     * @param string $cookie
     */
    public function __construct($cookie = "PHPSESSID")
    {
        session_name($cookie);
    }

    /**
     * @return bool
     */
    public function start()
    {
        $status = session_start();
        if ($status)
            $this->storage = (array) $_SESSION;

        return $status;
    }

    /**
     * @return bool
     */
    public function valid()
    {
        return session_status() == PHP_SESSION_ACTIVE;
    }

    /**
     * Update session data
     * @return void
     */
    private function _update()
    {
        $_SESSION = (array) $this->storage;
    }

    /**
     * @param string $name
     * @return boolean
     */
    public function exists($name)
    {
        return isset($this->storage[$name]);
    }

    /**
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public function write($name, $value)
    {
        $this->storage[$name] = $value;
        $this->_update();
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function read($name)
    {
        return $this->exists($name) ? $this->storage[$name] : null;
    }

    /**
     * @param string $name
     * @return void
     */
    public function delete($name)
    {
        unset($this->storage);
        $this->_update();
    }

    /**
     * @return void
     */
    public function destroy()
    {
        if (isset($_SESSION))
            session_destroy();
    }
}