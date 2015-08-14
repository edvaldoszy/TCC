<?php

namespace Szy\Database;

use ArrayIterator;

class ResultSet extends ArrayIterator
{
    /**
     * @return mixed
     */
    public function first()
    {
        $this->rewind();
        return $this->current();
    }
}