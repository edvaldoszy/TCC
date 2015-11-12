<?php

namespace FastFood\Controller;

use FastFood\Helper\JSONResponse;
use FastFood\Model;
use FastFood\Model\ProdutoModel;
use Szy\Database\PDOConnection;
use Szy\Mvc\Controller\AbstractController;
use Szy\Mvc\Controller\Controller;

class ProdutoController extends AbstractController
{
    /**
     * @var ProdutoModel
     */
    private $model;

    public function init()
    {
        $this->model = new ProdutoModel();
    }

    public function detalheAction($codigo)
    {
        $json = new JSONResponse($this);

        $produto = $this->model->produto($codigo);
        $json->set('produto', $produto);
        $json->set('itens', $this->model->itens($produto));

        $json->flush();
    }

    public function indexAction($codigo = null)
    {
        switch ($this->request->getMethod()) {
            case Controller::METHOD_GET:
                $this->doGetProduto($codigo);
                break;

            case Controller::METHOD_PUT:
                $this->doPutProduto($codigo);
                break;
        }
    }

    private function doGetProduto($codigo)
    {
        $model = new ProdutoModel();

        $busca = $this->getParam('busca', FILTER_SANITIZE_STRING);
        if (!empty($busca)) {

            $stmt = $model->query("SELECT po.*, mi.caminho AS imagem FROM produto po
            LEFT JOIN midia mi ON (mi.produto = po.codigo)
            WHERE po.tipo = 2 AND po.nome LIKE ?", array("%{$busca}%"));

        } else { // Se a busca é sem filtros

            $stmt = $model->query("SELECT po.*, mi.caminho AS imagem FROM produto po
            LEFT JOIN midia mi ON (mi.produto = po.codigo)
            WHERE po.tipo = 2");
        }

        $con = $model->getConnection();
        $stmtDesc = $con->prepare("SELECT po.nome FROM produto_item pt
            INNER JOIN produto po ON (po.codigo = pt.item)
            WHERE po.tipo = 1 AND pt.produto = ?");

        $res = new \ArrayIterator();
        while ($row = $stmt->fetchObject()) {
            $row->valor = floatval($row->valor);
            $row->ativo = boolval($row->ativo);
            $row->tipo = intval($row->tipo);
            $res->append($row);

            $row->categoria = $this->model->categoria($row->categoria);

            $stmtDesc->bindValue(1, $row->codigo, PDOConnection::PARAM_INT);
            $stmtDesc->execute();

            $desc = new \ArrayIterator();
            while ($item = $stmtDesc->fetchObject()) {
                $desc->append($item->nome);
            }
            $row->descricao = implode(', ', $desc->getArrayCopy());
        }

        $json = new JSONResponse($this);
        $json->setData($res->getArrayCopy());
        $json->flush();
    }

    private function doPutProduto($codigo) {}
}