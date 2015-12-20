<?php

namespace Application\Model;

use Szy\Mvc\Model\AbstractModel;
use Szy\Util\Math;

class ProdutoModel extends AbstractModel
{
	const ATIVO = '1';
	const INVATIVO = '0';

	const ADICIONAL = '1';

	const TIPO_ITEM = '1';
	const TIPO_PRODUTO = '2';

	public function listar($tipo, $pagina, $limite = 20)
	{
		$offset = ($pagina > 1) ? (Math::abs($pagina - 1) * $limite) : 0;

		//$res = $this->select('produto', null, 'tipo = ?', array(2), 'nome ASC', $limite, $offset);
		$stmt = $this->query("SELECT po.*, ca.nome AS categoria FROM produto po INNER JOIN categoria ca ON (ca.codigo = po.categoria)
			WHERE tipo = ? ORDER BY po.nome ASC LIMIT ? OFFSET ?",
			array($tipo, $limite, $offset)
		);
		$res = $stmt->fetchAll();
		for ($n = 0; $n < count($res); $n++) {
			$row = &$res[$n];
			$row->str_ativo = $row->ativo == self::ATIVO ? 'Sim' : 'Não';
		}

		return $res;
	}

	public function itens($produto)
	{
		$stmt = $this->query("SELECT po.*, ca.nome AS categoria, pi.quantidade, pi.valor, pi.adicional, pi.produto AS produto_codigo, pi.item AS item_codigo FROM produto_item pi
		INNER JOIN produto po ON (po.codigo = pi.item)
		INNER JOIN categoria ca ON (ca.codigo = po.categoria)
		WHERE po.tipo = 1 AND pi.produto = ?", array($produto->codigo));

		$res = $stmt->fetchAll();
		for ($n = 0; $n < count($res); $n++) {
			$row = &$res[$n];
			$row->str_adicional = $row->adicional == self::ADICIONAL ? 'Sim' : 'Não';
		}

		return $res;
	}

	public function item($produto, $item)
	{
		$stmt = $this->query("SELECT po.nome, pi.* FROM produto_item pi
		INNER JOIN produto po ON (po.codigo = pi.item)
		WHERE pi.produto = ? AND pi.item = ?", array($produto, $item));

		return $stmt->fetchObject();
	}
}