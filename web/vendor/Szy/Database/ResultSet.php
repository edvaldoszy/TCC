<?php

namespace Szy\Database;

use ArrayIterator;
use Szy\Util\DateTime;

class ResultSet extends ArrayIterator
{
    /**
     * @param $column
     * @return mixed
     */
    public function getValue($column)
    {
        $row = $this->current();
        return isset($row->$column) ? $row->$column : null;
    }

    /**
     * @param $column
     * @return DateTime
     */
    public function getDate($column)
    {
        return !is_null($this->getValue($column)) ? new DateTime($this->getValue($column)) : null;
    }

    /**
     * @param $column
     * @return int
     */
    public function getInt($column)
    {
        return (int) $this->getValue($column);
    }

    /**
     * @param $column
     * @return bool
     */
    public function getBool($column)
    {
        return (boolean) $this->getValue($column);
    }

    public function first()
    {
        $this->rewind();
        return $this->current();
    }

    public function getFormatedValue($column, $format)
    {

    }
}