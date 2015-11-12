<?php

namespace Szy\Mvc\Model;

use Szy\Database\Connection;
use Szy\Database\PDOConnection;
use Szy\Database\ResultSet;
use Szy\Mvc\Application;

abstract class AbstractModel implements Model
{
    /**
     * @var Connection
     */
    private static $connection;

    /**
     * @return Connection
     */
    public function getConnection()
    {
        if (self::$connection == null) {
            $conf = Application::getConfig("database");
            self::$connection = new PDOConnection($conf["host"], $conf["user"], $conf["pass"], $conf["name"]);
            unset($conf);
        }
        return self::$connection;
    }

	/**
     * @param \PDOStatement $stmt
     * @param array $arguments
     */
    private function bindValues(\PDOStatement $stmt, $arguments)
    {
        for ($n = 1; $n <= count($arguments); $n++) {
            $v = $arguments[$n-1];
            switch (strtolower(gettype($v))) {
                case 'integer':
                    $stmt->bindValue($n, $v, \PDO::PARAM_INT);
                    break;
                case 'boolean':
                    $stmt->bindValue($n, $v, \PDO::PARAM_BOOL);
                    break;
                case 'null':
                    $stmt->bindValue($n, $v, \PDO::PARAM_NULL);
                    break;
                case 'string':
                    $stmt->bindValue($n, $v, \PDO::PARAM_STR);
                    break;
                default:
                    $stmt->bindValue($n, $v, \PDO::PARAM_STR);
                    break;
            }
        }
    }

    /**
     * @param ResultSet $rs
     * @return mixed
     */
    //protected abstract function createObject(ResultSet $rs);

    /**
     * @param string $statement
     * @param array $arguments
     * @return boolean
     */
    public function execute($statement, array $arguments = null)
    {
        $stmt = $this->getConnection()->prepare($statement);
        $this->bindValues($stmt, $arguments);
        return $stmt->execute();
    }

    /**
     * @param string $statement
     * @param array $arguments
     * @return \PDOStatement
     */
    public function query($statement, array $arguments = null)
    {
        $stmt = $this->getConnection()->prepare($statement);
        $this->bindValues($stmt, $arguments);
        $stmt->execute();
        return $stmt;
        //return new ResultSet($stmt->fetchAll(\PDO::FETCH_CLASS, 'Szy\Database\Record'));
    }

    /**
     * @param string $column
     * @return int
     */
    public function lastID($column)
    {
        return intval($this->getConnection()->lastID($column));
    }

    /**
     * @param string $table
     * @param array $columns
     * @param string $where
     * @param array $arguments
     * @param string $order
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function select($table, array $columns = null, $where = null, array $arguments = null, $order = null, $limit = null, $offset = null)
    {
        $str = '';
        $columns = $columns == null ? '*' : implode(', ', $columns);

        if ($where !== null)
            $str .= sprintf('WHERE %s', $where);

        if ($order !== null)
            $str .= sprintf(' ORDER BY %s', $order);

        if ($limit !== null && is_numeric($limit))
            $str .= sprintf(' LIMIT %d', $limit);

        if ($offset !== null && is_numeric($offset))
            $str .= sprintf(' OFFSET %d', $offset);

        $sql = trim(sprintf('SELECT %s FROM %s %s', $columns, $table, $str));
        $stmt = $this->query($sql, $arguments);

        return $stmt->fetchAll();
    }

    /**
     * @param string $table
     * @param array $columns
     * @param string $where
     * @param array $arguments
     * @param string $order
     * @return mixed
     */
    public function row($table, array $columns = null, $where = null, array $arguments = null, $order = null)
    {
        $rs = $this->select($table, $columns, $where, $arguments, $order, 1);
        if (count($rs) > 0)
        return $rs[0];
    }

    /**
     * @param string $table
     * @param array $arguments
     * @return bool
     * @throws ModelException
     */
    public function insert($table, array $arguments)
    {
        $columns = array_keys($arguments);
        $values = array_values($arguments);

        if (count($columns) !== count($arguments))
            throw new ModelException('Number of columns does not match the number os values');

        $cols = $args = '';
        for ($n = 0; $n < count($arguments); $n++) {
            $cols .= $n == 0 ? $columns[$n] : ", {$columns[$n]}";
            $args .= $n == 0 ? '?' : ', ?';
        }

        $sql = trim(sprintf('INSERT INTO %s (%s) VALUES (%s)', $table, $cols, $args));
        return $this->execute($sql, $values);
    }

    /**
     * @param string $table
     * @param array $arguments
     * @param string $where
     * @param array $whereArguments
     * @return bool
     * @throws ModelException
     */
    public function update($table, array $arguments, $where = null, array $whereArguments = null)
    {
        $columns = array_keys($arguments);
        $values = array_values($arguments);

        if (count($columns) !== count($arguments))
            throw new ModelException('Number of columns does not match the number os values');

        $str = '';
        for ($n = 0; $n < count($arguments); $n++)
            $str .= $n == 0 ? "{$columns[$n]} = ?" : ", {$columns[$n]} = ?";

        if ($where !== null)
            $str .= sprintf(' WHERE %s', $where);

        if ($whereArguments !== null)
            $arguments = array_merge(array_values($arguments), $whereArguments);

        $sql = trim(sprintf('UPDATE %s SET %s', $table, $str));
        return $this->execute($sql, $arguments);
    }

    /**
     * @param string $table
     * @param string $where
     * @param array $arguments
     * @return bool
     */
    public function delete($table, $where = null, array $arguments = null)
    {
        $where = $where  == null ? '' : sprintf('WHERE %s', $where);
        $sql = sprintf('DELETE FROM %s %s', $table, $where);
        return $this->execute($sql, $arguments);
    }

    /**
     * Metodo obtem as propriedades do object como uma array para fazer operações com SQL
     * O segundo parâmetro serve para dizer se as propriedades com valores nulos devem ou não vir na lista
     *
     * @param object $object
     * @param bool $null Determina se os propriedades com valores nulos devem ou não serem retornados na lista
     * @param array $offset Determina quais propriedades não deveram estar na lista
     * @return array
     */
    private function getObjectFields($object, $null = true, $offset = array())
    {
        $fields = array();
        $rf = new \ReflectionClass($object);
        $props = $rf->getProperties();

        foreach ($props as $property) {
            $property->setAccessible(true);
            $value = $property->getValue($object);
            $name = $property->getName();

            if ((!empty($value) || $null) && !in_array($name, $offset))
                $fields[$name] = $value;
        }

        return $fields;
    }

    /**
     * @param string $table
     * @param object $object
     */
    public function updateObject($table, $object)
    {
        if (!is_object($object))
            throw new \InvalidArgumentException('Param must be an object');

        try {
            $fields = (array) $object;
            unset($fields['codigo']);

            $args = '';
            foreach ($fields as $k => $v)
                $args .= ($args == '') ? "{$k} = ?" : ", {$k} = ?";

            $sql = sprintf('UPDATE %s SET %s WHERE codigo = ?', $table, $args);
            array_push($fields, $object->codigo);
            $this->execute($sql, array_values($fields));
        } catch (\ReflectionException $ex) {
            echo $ex->getMessage();
        }
    }

    /**
     * @param string $table
     * @param object $object
     */
    public function insertObject($table, $object)
    {
        if (!is_object($object))
            throw new \InvalidArgumentException('Param must be an object');

        try {
            $fields = $this->getObjectFields($object);

            $cols = $args = '';
            foreach ($fields as $k => $v) {
                $cols .= ($cols == '') ? "{$k}" : ", {$k}";
                $args .= ($args == '') ? "?" : ", ?";
            }

            $sql = sprintf('INSERT INTO %s (%s) VALUES (%s)', $table, $cols, $args);
            $this->execute($sql, array_values($fields));
        } catch (\ReflectionException $ex) {
            echo $ex->getMessage();
        }
    }

    /**
     * @param string $table
     * @param object $object
     * @throws \Exception
     */
    public function selectObject($table, $object)
    {
        throw new \Exception('Not supported yet');
    }
}