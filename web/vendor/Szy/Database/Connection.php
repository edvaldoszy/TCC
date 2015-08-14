<?php

namespace Szy\Database;

interface Connection
{
    /**
     * @param string $statement
     * @return \PDOStatement
     */
    public function prepare($statement);
}
