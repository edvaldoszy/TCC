<?php

namespace FastFood\Controller;

use FastFood\Helper\JSONResponse;
use FastFood\Model;
use FastFood\Model\ProdutoModel;
use Szy\Database\PDOConnection;
use Szy\Http\Request;
use Szy\Mvc\Controller\Controller;

class ProdutoController extends AdminController
{
    /**
     * @var ProdutoModel
     */
    private $model;

    public function init()
    {
        parent::init();
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

    public function votarAction($cliente, $produto, $nota)
    {
        if (!$this->isMethod(Request::METHOD_POST)) {
            $this->response->setStatus(400);
            return;
        }

        $model = new ProdutoModel();
        $produto = $model->row('produto', null, 'codigo = ?', array($produto));
        $cliente = $model->row('cliente', null, 'codigo = ?', array($cliente));
        if ($produto == null || $cliente == null || !preg_match('/[1-5]+/', $nota)) {
            $this->response->setStatus(400);
            return;
        }

        $obs = $this->getPost('obs', FILTER_SANITIZE_STRING);

        try {
            $model->insert('classificacao', array(
                'cliente' => $cliente->codigo,
                'produto' => $produto->codigo,
                'nota' => $nota,
                'obs' => $obs
            ));
            $this->response->setStatus(200);
        } catch (\Exception $ex) {
            $this->response->setStatus(500, 'Voce ja votou neste produto');
        }
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

            $stmt = $model->query("SELECT po.*, mi.caminho AS imagem, COALESCE((SUM(ca.nota) / COUNT(ca.nota)), 0) as nota FROM produto po
            LEFT JOIN midia mi ON (mi.produto = po.codigo)
            LEFT JOIN classificacao ca ON (ca.produto = po.codigo)
            WHERE po.tipo = 2 AND po.nome LIKE ? GROUP BY po.codigo ORDER BY nota DESC LIMIT 30", array("%{$busca}%"));

        } else { // Se a busca é sem filtros

                $stmt = $model->query("SELECT po.*, mi.caminho AS imagem, COALESCE((SUM(ca.nota) / COUNT(ca.nota)), 0) as nota FROM produto po
            LEFT JOIN midia mi ON (mi.produto = po.codigo)
            LEFT JOIN classificacao ca ON (ca.produto = po.codigo)
            WHERE po.tipo = 2 GROUP BY po.codigo ORDER BY nota DESC LIMIT 30");
        }

        $con = $model->getConnection();
        $stmtDesc = $con->prepare("SELECT po.nome FROM produto_item pt
            INNER JOIN produto po ON (po.codigo = pt.item)
            WHERE po.tipo = 1 AND pt.produto = ? AND pt.adicional = 0");

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