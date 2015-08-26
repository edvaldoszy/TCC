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
     * @param boolean $status
     * @return void
     */
    public function debug($status);
}