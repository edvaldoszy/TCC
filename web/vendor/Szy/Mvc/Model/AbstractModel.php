<?php

namespace Szy\Mvc\Model;

use ArrayIterator;
use Szy\Database\Connection;
use Szy\Database\PDOConnection;
use Szy\Database\Record;
use Szy\Database\ResultSet;
use Szy\Mvc\Application;

abstract class AbstractModel implements Model
{
    /**
     * @var string $table
     */
    protected $table = 'model';

    /**
     * @var Connection
     */
    private static $connection;

    /**
     * @return Connection
     */
    protected function getConnection()
    {
        if (null == self::$connection) {
            $db = Application::getConfig("database");
            self::$connection = new PDOConnection($db["host"], $db["user"], $db["pass"], $db["name"]);
            unset($db);
        }
        return self::$connection;
    }

    /**
     * @param \PDOStatement $stmt
     * @param ArrayIterator $values
     */
    private function bindValues($stmt, ArrayIterator $values)
    {
        for ($n = 1; $n < $values->count(); $n++) {
            $v = $values->current();

            if (is_numeric($v))
                $p = self::PARAM_INT;
            else if (is_bool($v))
                $p = self::PARAM_BOOL;
            else
                $p = self::PARAM_STR;

            $stmt->bindValue($n, $v, $p);
            $values->next();
        }
    }

    /**
     * @param string $statement
     * @param array $arguments
     * @return ResultSet
     */
    public function query($statement, array $arguments = null)
    {
        $stmt = $this->getConnection()->prepare($statement);
        $stmt->execute($arguments);
        return new ResultSet($stmt->fetchAll(\PDO::FETCH_CLASS, 'Szy\Database\Record'));
    }

    /**
     * @param array $columns
     * @param array $where
     * @param array $arguments
     * @param string $order
     * @param int $limit
     * @param int $offset
     * @return ResultSet
     */
    public function select(array $columns = null, $where = null, array $arguments = null, $order = null, $limit = null, $offset = null)
    {
        $columns = is_null($columns) ? "*" : implode(", ", $columns);
        $where = is_null($where) ? "" : "WHERE {$where}";
        $order = is_null($order) ? "" : "ORDER BY {$order}";
        $limit = is_null($limit) ? "" : "LIMIT {$limit}";
        $offset = is_null($offset) ? "" : "OFFSET {$offset}";

        $sql = "SELECT {$columns} FROM {$this->table} {$where} {$order} {$limit} {$offset}";
        return $this->query($sql, $arguments);
    }

    /**
     * @param array|null $columns
     * @param null $where
     * @param array|null $arguments
     * @param string $order
     * @return Record
     */
    public function row(array $columns = null, $where = null, array $arguments = null, $order = null)
    {
        $rset = $this->select($this->table, $columns, $where, $arguments, $order, 1);
        return $rset->first();
    }

    /**
     * @param array $arguments
     * @return bool
     * @throws \Exception
     */
    public function insert(array $arguments)
    {
        $columns = new ArrayIterator(array_keys($arguments));
        $values = new ArrayIterator(array_values($arguments));

        if ($columns->count() !== $values->count())
            throw new \Exception("Número de colunas não é igual ao número de valores");

        $args = "";
        $cols = "";
        for ($x = 0; $x < $columns->count(); $x++) {
            $cols .= $x == 0 ? "`{$columns->current()}`" : ", `{$columns->current()}`";
            $args .= $x == 0 ? "?" : ", ?";
            $columns->next();
        }

        $sql = "INSERT INTO `{$this->table}` ({$cols}) VALUES ({$args})";
        $stmt = $this->getConnection()->prepare($sql);
        $this->bindValues($stmt, $values);
        return $stmt->execute();
    }

    public function lastInsertId($name)
    {
        return $this->getConnection()->lastInsertId($name);
    }

    /**
     * @param array $arguments
     * @param string $where
     * @param array $whereArguments
     * @return bool
     */
    public function update(array $arguments, $where = null, array $whereArguments = null)
    {
        $columns = new ArrayIterator(array_keys($arguments));
        $av = is_null($whereArguments) ? array_values($arguments) : array_merge(array_values($arguments), $whereArguments);
        $values = new ArrayIterator($av);
        $where = is_null($where) ? "" : "WHERE {$where}";

        $cols = "";
        for ($x = 0; $x < $columns->count(); $x++) {
            $cols .= $x == 0 ? "`{$columns->current()}` = ?" : ", `{$columns->current()}` = ?";
            $columns->next();
        }

        $sql = "UPDATE `{$this->table}` SET {$cols} {$where}";
        $stmt = $this->getConnection()->prepare($sql);
        $this->bindValues($stmt, $values);
        return $stmt->execute();
    }

    /**
     * @param null $where
     * @param array $arguments
     * @return bool
     */
    public function delete($where = null, array $arguments = null)
    {
        $where = is_null($where) ? "" : "WHERE {$where}";
        $sql = "DELETE FROM `{$this->table}` {$where}";
        $stmt = $this->getConnection()->prepare($sql);
        $this->bindValues($stmt, new ArrayIterator($arguments));

        return $stmt->execute();
    }

    public function logsys($usuario, $descricao)
    {
        $date = new DateTime();
        $ip = $_SERVER["REMOTE_ADDR"];
        $this->insert("log", array("data" => $date->format("Y-m-d H:i:s"), "usuario" => $usuario, "descricao" => $descricao, "ip" => $ip));
    }

    public function getTable()
    {
        $this->table;
    }
} 