<?php

namespace Application\Controller;

use Application\Helper\Message;
use Application\Helper\RegexValidatorException;
use Application\Model\CategoriaModel;
use Application\View\ApplicationView;
use Szy\Http\Request;
use Szy\Mvc\View\View;

class CategoriaController extends AdminController
{
    private function listagem(View $view, $pagina = 1)
    {
        $view->setTitle('Categorias');

        $model = new CategoriaModel();
        $view->setAttribute('categorias', $model->listar($pagina));
        $view->flush();
    }

    public function indexAction()
    {
        $view = new ApplicationView($this, 'categoria/index');
        $this->listagem($view);
    }

    public function cadastrarAction()
    {
        $view = new ApplicationView($this, 'categoria/formulario');
        $view->setTitle('Cadastrar categoria');

        if ($this->isMethod(Request::METHOD_POST)) {
            $nome = $this->getNome();
            try {
                $nome->validate(true);
                $model = new CategoriaModel();
                $model->insert('categoria', array('nome' => $nome->getValue()));
                $this->response->sendRedirect('/categorias/alterar/' . $model->lastID('codigo') . '?sucesso=s');
            } catch (RegexValidatorException $ex) {
                $view->setMessage(new Message($ex->getMessage(), Message::TYPE_DANGER));
            }
        }
        $view->flush();
    }

    public function alterarAction($codigo)
    {
        $view = new ApplicationView($this, 'categoria/formulario');
        $view->setTitle('Alterar categoria');

        $model = new CategoriaModel();

        if ($this->isMethod(Request::METHOD_POST)) {
            $nome = $this->getNome();
            try {
                $nome->validate(true);
                $model->update('categoria', array('nome' => $nome->getValue()), 'codigo = ?', array($codigo));

                $view->setMessage(new Message('Categoria alterada com sucesso', Message::TYPE_SUCCESS));
            } catch (RegexValidatorException $ex) {
                $view->setMessage(new Message($ex->getMessage(), Message::TYPE_DANGER));
            }
        } else {
            $categoria = (array) $model->row('categoria', null, 'codigo = ?', array($codigo));
            $view->data = $categoria;

            if ($this->getParam('sucesso') == 's')
                $view->setMessage(new Message('Categoria cadastrada com sucesso', Message::TYPE_SUCCESS));
        }
        $view->flush();
    }

    public function excluirAction($codigo)
    {
        $view = new ApplicationView($this, 'categoria/index');

        $model = new CategoriaModel();
        try {
            $model->delete('categoria', 'codigo = ?', array($codigo));
            $view->setMessage(new Message('Categoria excluída', Message::TYPE_SUCCESS));
        } catch (\PDOException $ex) {
            if (strpos($ex->getMessage(), '1451') > -1)
                $view->setMessage(new Message('Não foi possível excluir, esta categoria está sendo utilizada', Message::TYPE_DANGER));
        }
        $this->listagem($view);
    }
}