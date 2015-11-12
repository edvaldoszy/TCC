<?php

namespace FastFood;

use Szy\Database\ResultSet;
use Szy\Mvc\Model\AbstractModel;

class Model extends AbstractModel
{
    /**
     * @var Model
     */
    private static $model;

    public static function getModel()
    {
        if (self::$model == null)
            self::$model = new Model();

        return self::$model;
    }

    public static function getConn()
    {
        return self::getModel()->getConnection();
    }

    protected function createObject(ResultSet $rs)
    {
        return null;
    }
}