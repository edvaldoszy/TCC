<?php

namespace Szy\Http;

interface Session
{
    /**
     * @return boolean
     */
    public function start();

    /**
     * @return boolean
     */
    public function valid();

    /**
     * @param string $name
     * @return boolean
     */
    public function exists($name);

    /**
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public function write($name, $value);

    /**
     * @param string $name
     * @return mixed
     */
    public function read($name);

    /**
     * @param string $name
     * @return void
     */
    public function delete($name);

    /**
     * @return void
     */
    public function destroy();
}