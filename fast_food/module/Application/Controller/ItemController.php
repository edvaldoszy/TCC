<?php

namespace Application\Controller;

use Application\Helper\Message;
use Application\Helper\RegexValidatorException;
use Application\Model\ProdutoModel;
use Application\View\ApplicationView;
use Szy\Http\Request;
use Szy\Mvc\View\View;

class ItemController extends AdminController
{
    private function listagem(View $view, $pagina = 1)
    {
        $view->setTitle('Itens');

        $model = new ProdutoModel();
        $view->setAttribute('produtos', $model->listar(ProdutoModel::TIPO_ITEM, $pagina));
        $view->flush();
    }

    public function indexAction($pagina = 1)
    {
        $view = new ApplicationView($this, 'produto/item_index');
        $this->listagem($view);
    }

    public function cadastrarAction()
    {
        $view = new ApplicationView($this, 'produto/item_formulario');
        $view->setTitle('Cadastrar Item');

        $model = new ProdutoModel();
        if ($this->isMethod(Request::METHOD_POST)) {

            $nome = $this->getNome();
            $valor = $this->getValor();
            $categoria = $this->getCategoria();

            try {
                $nome->validate(true);
                $valor->validate(true);
                $categoria->validate(true);

                $model->insert('produto', array(
                    'nome' => $nome->getValue(),
                    'valor' => $valor->getValue(),
                    'categoria' => $categoria->getValue(),
                    'tipo' => ProdutoModel::TIPO_ITEM,
                    'ativo' => 1
                ));
                $codigo = $model->lastID('codigo');

                $view->setMessage(new Message('Item alterado com sucesso', Message::TYPE_SUCCESS));
                $this->response->sendRedirect('/estoque/itens/alterar/' . $codigo . '?sucesso=s');
            } catch (RegexValidatorException $ex) {
                $view->setMessage(new Message($ex->getMessage(), Message::TYPE_DANGER));
            }
        }
        $view->data['categorias'] = $model->select('categoria');
        $view->flush();
    }

    public function alterarAction($codigo)
    {
        $view = new ApplicationView($this, 'produto/item_formulario');
        $view->setTitle('Alterar Item');

        $model = new ProdutoModel();
        $produto = $model->row('produto', null, 'codigo = ?', array($codigo));

        if ($this->isMethod(Request::METHOD_POST)) {

            $nome = $this->getNome();
            $valor = $this->getValor();
            $categoria = $this->getCategoria();
            try {
                $nome->validate(true);
                $valor->validate(true);
                $categoria->validate(true);

                // Atualiza as informações do produto no banco de dados
                $model->update('produto', array(
                    'nome' => $nome->getValue(),
                    'valor' => $valor->getValue(),
                    'categoria' => $categoria->getValue()
                ),
                    'codigo = ?', array($codigo));

                $view->setMessage(new Message('Item alterado com sucesso', Message::TYPE_SUCCESS));
            } catch (RegexValidatorException $ex) {
                $view->setMessage(new Message($ex->getMessage(), Message::TYPE_DANGER));
            }
        } else {
            // Caso não esteja gravando, guarda os dados do produto obtidos do bando de dados
            // na view para mostrar na tela
            $view->data = (array) $produto;

            if ($this->getParam('sucesso') == 's')
                $view->setMessage(new Message('Item cadastrado com sucesso', Message::TYPE_SUCCESS));
        }

        $view->data['categorias'] = $model->select('categoria');
        $view->flush();
    }

    public function excluirAction($codigo)
    {
        $view = new ApplicationView($this, 'produto/item_index');

        $model = new ProdutoModel();
        try {
            $model->delete('produto', 'tipo = ? AND codigo = ?', array(ProdutoModel::TIPO_ITEM, $codigo));
            $view->setMessage(new Message('Item excluído', Message::TYPE_SUCCESS));
        } catch (\PDOException $ex) {
            $view->setMessage(new Message($ex->getMessage(), Message::TYPE_DANGER));
        }
        $this->listagem($view);
    }
}