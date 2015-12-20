<?php

namespace FastFood\Model;

use Szy\Database\ResultSet;
use Szy\Mvc\Model\AbstractModel;
use Szy\Mvc\Model\ModelException;

class ProdutoModel extends AbstractModel
{
    protected function createObject(ResultSet $rs)
    {
        // TODO: Implement createObject() method.
    }

    public function produtos()
    {
        $stmt = $this->query("SELECT * FROM produto");

        $res = new \ArrayIterator();
        while ($row = $stmt->fetchObject()) {

            $row->valor = floatval($row->valor);
            $row->ativo = boolval($row->ativo);
            $row->tipo = intval($row->tipo);
            $row->img = 'http://172.18.1.127/integrado/tcc/api/img/h.jpg';
            $row->categoria = $this->categoria($row->categoria);
            $res->append($row);
        }
        return $res;
    }

    public function produto($codigo)
    {
        if (empty($codigo))
            throw new ModelException('Parametro codigo nao informado');

        $stmt = $this->query("SELECT po.*, mi.caminho AS imagem FROM produto po
        LEFT JOIN midia mi ON (mi.produto = po.codigo)
        WHERE po.codigo = ? LIMIT 1", array($codigo));

        $row = $stmt->fetchObject();
        $row->valor = floatval($row->valor);
        $row->ativo = boolval($row->ativo);
        $row->tipo = intval($row->tipo);
        $row->categoria = $this->categoria($row->categoria);

        return $row;
    }

    public function categorias()
    {
        $stmt = $this->query("SELECT * FROM categoria");

        $res = new \ArrayIterator();
        while ($row = $stmt->fetchObject()) {
            $res->append($row);
        }
        return $res;
    }

    public function categoria($codigo)
    {
        if (empty($codigo))
            throw new ModelException('Parametro codigo nao informado');

        $stmt = $this->query("SELECT * FROM categoria WHERE codigo = ?", array($codigo));
        return $stmt->fetchObject();
    }

    public function itens($produto) {

        if ($produto == null || !isset($produto->codigo))
            throw new ModelException("Informe um produto para consulta");

        $stmt = $this->query("SELECT pt.* FROM produto_item pt
        INNER JOIN produto po ON (po.codigo = pt.item)
        WHERE po.tipo = 1 AND pt.produto = ? ORDER BY pt.adicional", array($produto->codigo));

        $res = $stmt->fetchAll();
        foreach ($res as $k => $row) {
            $item = $this->produto($row->item);
            $item->quantidade = floatval($row->quantidade);
            $item->adicional = boolval($row->adicional);
            $item->valor = floatval($row->valor);
            unset($item->categoria);
            $res[$k] = $item;
        }

        return $res;
    }
}