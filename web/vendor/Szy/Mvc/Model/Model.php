<?php

namespace Szy\Mvc\Model;

use Szy\Database\Record;
use Szy\Database\ResultSet;

interface Model
{
    /**
     * SQL INT data type
     */
    const PARAM_INT = \PDO::PARAM_INT;

    /**
     * SQL CHAR, VARCHAR data type
     */
    const PARAM_STR = \PDO::PARAM_STR;

    /**
     * SQL BOOLEAN data type
     */
    const PARAM_BOOL = \PDO::PARAM_BOOL;

    /**
     * SQL NULL data type
     */
    const PARAM_NULL = \PDO::PARAM_NULL;

    /**
     * SQL LARGE OBJECT data type
     */
    const PARAM_LOB = \PDO::PARAM_LOB;

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
     * @return Record
     */
    public function row(array $columns = null, $where = null, array $arguments = null, $order = null);

    /**
     * @param array $arguments
     * @return bool
     */
    public function insert(array $arguments);

    /**
     * @param array $arguments
     * @param string $where
     * @param array $arguments
     * @return bool
     */
    public function update(array $arguments, $where = null, array $arguments = null);

    /**
     * @param string $where
     * @param array $arguments
     * @return bool
     */
    public function delete($where = null, array $arguments = null);
}