<?php

namespace Szy\Database;

use ArrayIterator;

class ResultSet extends ArrayIterator
{
    /**
     * @return Record
     */
    public function first()
    {
        $this->rewind();
        return $this->current();
    }
}