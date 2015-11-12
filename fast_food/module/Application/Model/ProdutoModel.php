<?php

namespace Application\Model;

use Szy\Mvc\Model\AbstractModel;
use Szy\Util\Math;

class ProdutoModel extends AbstractModel
{
	const ATIVO = '1';
	const INVATIVO = '0';

	public function listar($tipo, $pagina, $limite = 20)
	{
		$offset = ($pagina > 1) ? (Math::abs($pagina - 1) * $limite) : 0;

		//$res = $this->select('produto', null, 'tipo = ?', array(2), 'nome ASC', $limite, $offset);
		$stmt = $this->query(
			'SELECT po.*, ca.nome AS categoria FROM produto po INNER JOIN categoria ca ON (ca.codigo = po.categoria) WHERE tipo = ? ORDER BY po.nome ASC LIMIT ? OFFSET ?',
			array($tipo, $limite, $offset)
		);
		$res = $stmt->fetchAll();
		for ($n = 0; $n < count($res); $n++) {
			$row = &$res[$n];
			$row->str_ativo = $row->ativo == self::ATIVO ? 'Sim' : 'Não';
		}

		return $res;
	}
}