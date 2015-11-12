<?php

namespace Szy\Mvc\Model;

use Szy\Database\Connection;
use Szy\Database\Record;
use Szy\Database\ResultSet;

interface Model
{
    /**
     * @return Connection
     */
    public function getConnection();

	/**
     * @param string $statement
     * @param array $arguments
     * @return boolean
     */
    public function execute($statement, array $arguments = null);

    /**
     * @param string $statement
     * @param array $arguments
     * @return ResultSet
     */
    public function query($statement, array $arguments = null);

    /**
     * @param string $table
     * @param array $columns
     * @param string $where
     * @param array $arguments
     * @param string $order
     * @param int $limit
     * @param int $offset
     * @return ResultSet
     */
    public function select($table, array $columns = null, $where = null, array $arguments = null, $order = null, $limit = null, $offset = null);

    /**
     * @param string $table
     * @param array $columns
     * @param string $where
     * @param array $arguments
     * @param string $order
     * @return Record
     */
    public function row($table, array $columns = null, $where = null, array $arguments = null, $order = null);

    /**
     * @param string $table
     * @param array $arguments
     * @return bool
     */
    public function insert($table, array $arguments);

    /**
     * @param string $table
     * @param array $arguments
     * @param string $where
     * @param array $whereArguments
     * @return bool
     */
    public function update($table, array $arguments, $where = null, array $whereArguments = null);

    /**
     * @param string $table
     * @param string $where
     * @param array $arguments
     * @return bool
     */
    public function delete($table, $where  = null, array $arguments = null);
}