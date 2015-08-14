<?php

namespace Szy\Database;

class PDOConnection extends \PDO implements Connection
{
    public $debug = false;

    /**
     * @param string $host
     * @param string $user
     * @param string $pass
     * @param string $name
     * @param string $charset
     */
    public function __construct($host, $user, $pass, $name, $charset = 'UTF8')
    {
        $dsn = "mysql:host={$host};dbname={$name};charset={$charset}";
        parent::__construct($dsn, $user, $pass);
        parent::setAttribute(static::ATTR_DEFAULT_FETCH_MODE, static::FETCH_OBJ);
        parent::setAttribute(static::ATTR_ERRMODE, static::ERRMODE_EXCEPTION);
    }

    /**
     * @param string $statement
     * @param array $options
     * @return \PDOStatement
     */
    public function prepare($statement, array $options = array())
    {
        if ($this->debug) var_dump($statement);
        return parent::prepare($statement, $options);
    }

    /**
     * @param string $statement
     * @return \PDOStatement
     */
    public function query($statement)
    {
        if ($this->debug) var_dump($statement);
        return parent::query($statement);
    }
} 