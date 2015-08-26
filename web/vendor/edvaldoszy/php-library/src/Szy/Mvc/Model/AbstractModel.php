<?php

namespace Szy\Mvc\Model;

use Szy\Database\Connection;
use Szy\Database\PDOConnection;
use Szy\Database\ResultSet;
use Szy\Mvc\Application;

abstract class AbstractModel implements Model
{
    /**
     * @var string
     */
    protected $table;

    /**
     * @var Connection
     */
    private static $connection;

    /**
     * @return Connection
     */
    public function getConnection()
    {
        if (self::$connection == null) {
            $conf = Application::getConfig("database");
            self::$connection = new PDOConnection($conf["host"], $conf["user"], $conf["pass"], $conf["name"]);
            unset($conf);
        }
        return self::$connection;
    }

    /**
     * @param boolean $status
     */
    public function debug($status)
    {
        $this->getConnection()->debug($status);
    }

    /**
     * @return string
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * @param string $statement
     * @param array $arguments
     * @return ResultSet
     */
    public function query($statement, array $arguments = null)
    {
        $stmt = $this->getConnection()->prepare($statement);
        $stmt->execute($arguments);
        return new ResultSet($stmt->fetchAll(\PDO::FETCH_CLASS, 'Szy\Database\Record'));
    }

    /**
     * @param array $columns
     * @param string $where
     * @param array $arguments
     * @param string $order
     * @param int $limit
     * @param int $offset
     * @return ResultSet
     */
    public function select(array $columns = null, $where = null, array $arguments = null, $order = null, $limit = null, $offset = null)
    {
        // TODO: Implement select() method.
    }

    /**
     * @param array $columns
     * @param string $where
     * @param array $arguments
     * @param string $order
     * @return ResultSet
     */
    public function row(array $columns = null, $where = null, array $arguments = null, $order = null)
    {
        // TODO: Implement row() method.
    }

    /**
     * @param array $arguments
     * @return int
     */
    public function insert(array $arguments)
    {
        // TODO: Implement insert() method.
    }

    /**
     * @param array $arguments
     * @param string $where
     * @param array $whereArguments
     * @return int
     */
    public function update(array $arguments, $where = null, array $whereArguments = null)
    {
        // TODO: Implement update() method.
    }

    /**
     * @param null $where
     * @param array $arguments
     * @return int
     */
    public function delete($where = null, array $arguments = null)
    {
        // TODO: Implement delete() method.
    }
}