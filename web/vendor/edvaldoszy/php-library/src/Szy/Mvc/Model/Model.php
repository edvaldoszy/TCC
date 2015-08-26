<?php

namespace Szy\Mvc\Model;

use Szy\Database\Connection;
use Szy\Database\ResultSet;

interface Model
{
    /**
     * @return string
     */
    public function getTable();

    /**
     * @return Connection
     */
    public function getConnection();

    /**
     * @param string $statement
     * @param array $arguments
     * @return ResultSet
     */
    public function query($statement, array $arguments = null);

    /**
     * @param array $columns
     * @param string $where
     * @param array $arguments
     * @param string $order
     * @param int $limit
     * @param int $offset
     * @return ResultSet
     */
    public function select(array $columns = null, $where = null, array $arguments = null, $order = null, $limit = null, $offset = null);

    /**
     * @param array $columns
     * @param string $where
     * @param array $arguments
     * @param string $order
     * @return ResultSet
     */
    public function row(array $columns = null, $where = null, array $arguments = null, $order = null);

    /**
     * @param array $arguments
     * @return int
     */
    public function insert(array $arguments);

    /**
     * @param array $arguments
     * @param string $where
     * @param array $whereArguments
     * @return int
     */
    public function update(array $arguments, $where = null, array $whereArguments = null);

    /**
     * @param null $where
     * @param array $arguments
     * @return int
     */
    public function delete($where  = null, array $arguments = null);
}