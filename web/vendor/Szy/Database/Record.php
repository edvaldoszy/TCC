<?php

namespace Szy\Database;

use Szy\Util\DateTime;

class Record
{
    /**
     * @param string $column
     * @return mixed|null
     */
    public function getValue($column)
    {
        return isset($this->$column) ? $this->$column : null;
    }

    /**
     * @param string $column
     * @return int
     */
    public function getInt($column)
    {
        return intval($this->getValue($column));
    }

    /**
     * @param string $column
     * @return bool
     */
    public function getBool($column)
    {
        return boolval($this->getValue($column));
    }

    /**
     * @param string $column
     * @return float
     */
    public function getFloat($column)
    {
        return floatval($this->getValue($column));
    }

    /**
     * @param string $column
     * @return DateTime|null
     */
    public function getDate($column)
    {
        return $this->getValue($column) != null ? new DateTime($this->getValue($column)) : null;
    }
}