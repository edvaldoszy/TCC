<?php

namespace Szy\Database;

use ArrayIterator;

class ResultSet extends ArrayIterator
{
    /**
     * @param string$column
     * @return mixed
     */
    private function _getValue($column)
    {
        $row = $this->current();
        return isset($row->$column) ? $row->$column : null;
    }

    /**
     * @param string $columns
     * @return string
     */
    public function getString($columns)
    {
        return strval($this->_getValue($columns));
    }

    /**
     * @param string $column
     * @return int
     */
    public function getInt($column)
    {
        return intval($this->_getValue($column));
    }

    /**
     * @param string $column
     * @return float
     */
    public function getFloat($column)
    {
        return floatval($this->_getValue($column));
    }

    /**
     * @param string $column
     * @return bool
     */
    public function getBool($column)
    {
        $value = $this->_getValue($column);
        return (is_string($value) && strtolower($value) == 'true') ? true : boolval($this->_getValue($column));
    }

    /**
     * @param string $column
     * @return \DateTime
     */
    public function getDate($column)
    {
        $value = $this->_getValue($column);
        if ($value !== null)
            $value = new \DateTime($value);

        return $value;
    }
}