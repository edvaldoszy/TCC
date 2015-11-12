<?php

namespace Szy\Database;

interface Connection
{
    /**
     * @param string $statement
     * @param array $options
     * @return \PDOStatement
     */
    public function prepare($statement, array $options = array());

    /**
     * @param string $statement
     * @return \PDOStatement
     */
    public function query($statement);

    /**
     * @param string $column
     * @return int
     */
    public function lastID($column);

	/**
     * @param boolean $status
     * @return void
     */
    public function debug($status = false);
}