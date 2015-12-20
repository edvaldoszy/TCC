<?php

namespace Application\Controller;

use Application\Helper\Message;
use Application\Helper\RegexValidatorException;
use Application\Helper\UploadHelper;
use Application\Model\ProdutoModel;
use Application\View\ApplicationView;
use Szy\Http\Request;
use Szy\Mvc\Application;
use Szy\Mvc\View\View;

class ProdutoController extends AdminController
{
    public function uploadAction()
    {
        if (!$this->isMethod(Request::METHOD_POST))
            return;

        $helper = new UploadHelper('imagem', '/upload/produtos/');
        $helper->run();

        $this->response->setContentType('application/json; charset=utf-8');
        $this->response->write(json_encode($helper->getLista()));

        $session = $this->getSession();
        $listaSession = $session->read('produto_imagens');
        if (is_array($listaSession))
            $session->write('produto_imagens', array_merge($listaSession, $helper->getLista()));
        else
            $session->write('produto_imagens', $helper->getLista());
    }

    private function listagem(View $view, $pagina = 1)
	{
		$view->setTitle('Produtos');

        if ($this->getSession()->exists('produto_imagens'))
            $this->getSession()->delete('produto_imagens');

		$model = new ProdutoModel();
		$view->setAttribute('produtos', $model->listar(ProdutoModel::TIPO_PRODUTO, $pagina));
		$view->flush();
	}

	public function indexAction($pagina = 1)
	{
		$view = new ApplicationView($this, 'produto/index');
		$this->listagem($view);
	}

    public function cadastrarAction()
    {
        if (!$this->permissao())
            return;

        $view = new ApplicationView($this, 'produto/formulario');
        $view->setTitle('Cadastrar produto');

        $model = new ProdutoModel();

        $imagens = $this->getSession()->read('produto_imagens');
        if ($imagens == null)
            $imagens = array();

        $view->setAttribute('imagens', $imagens);

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
                    'tipo' => ProdutoModel::TIPO_PRODUTO,
                    'ativo' => 1
                ));
                $codigo = $model->lastID('codigo');

                foreach ($imagens as $imagem) {
                    if (empty($imagem->codigo)) {
                        $model->insert('midia', array(
                            'titulo' => $imagem->titulo,
                            'caminho' => $imagem->caminho,
                            'produto' => $codigo
                        ));
                    }
                }
                $this->getSession()->delete('produto_imagens');

                $view->setMessage(new Message('Produto alterado com sucesso', Message::TYPE_SUCCESS));
                $this->response->sendRedirect('/estoque/produtos/alterar/' . $codigo . '?sucesso=s');
            } catch (RegexValidatorException $ex) {
                $view->setMessage(new Message($ex->getMessage(), Message::TYPE_DANGER));
            } catch (\Exception $ex) {
                Application::logsys(100, $ex->getMessage());
                $view->setMessage(new Message('Erro ao finalizar a operação. Entre em contato com o administrador do sistema.', Message::TYPE_DANGER));
            }
        }
        $view->data['categorias'] = $model->select('categoria');
        $view->flush();
    }

	public function alterarAction($codigo)
	{
        if (!$this->permissao())
            return;

		$view = new ApplicationView($this, 'produto/formulario');
		$view->setTitle('Alterar produto');

		$model = new ProdutoModel();
        $produto = $model->row('produto', null, 'codigo = ?', array($codigo));

        $imagensSelect = $model->select('midia', null, 'produto = ?', array($produto->codigo));
        if ($imagensSelect == null)
            $imagensSelect = array();

        $imagensSession = $this->getSession()->read('produto_imagens');
        if ($imagensSession == null)
            $imagensSession = array();

        $imagens = array_merge($imagensSelect, $imagensSession);
        $view->setAttribute('imagens', $imagens);

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
                    'categoria' => $categoria->getValue()),
                    'codigo = ?', array($codigo)
                );

                foreach ($imagens as $imagem) {
                    if (empty($imagem->codigo)) {
                        $model->insert('midia', array(
                            'titulo' => $imagem->titulo,
                            'caminho' => $imagem->caminho,
                            'produto' => $produto->codigo
                        ));
                    }
                }
                $this->getSession()->delete('produto_imagens');

				$view->setMessage(new Message('Produto alterado com sucesso', Message::TYPE_SUCCESS));
			} catch (RegexValidatorException $ex) {
				$view->setMessage(new Message($ex->getMessage(), Message::TYPE_DANGER));
			} catch (\Exception $ex) {
                Application::logsys(100, $ex->getMessage());
                $view->setMessage(new Message('Erro ao finalizar a operação. Entre em contato com o administrador do sistema.', Message::TYPE_DANGER));
            }
		} else {
            // Caso não esteja gravando, guarda os dados do produto obtidos do bando de dados
            // na view para mostrar na tela
			$view->data = (array) $produto;

			if ($this->getParam('sucesso') == 's')
				$view->setMessage(new Message('Produto cadastrado com sucesso', Message::TYPE_SUCCESS));
		}

        $view->data['categorias'] = $model->select('categoria');
		$view->flush();
	}

    public function excluirAction($codigo)
    {
        if (!$this->permissao())
            return;

        $view = new ApplicationView($this, 'produto/index');

        $model = new ProdutoModel();
        try {
            $model->delete('produto', 'tipo = ? AND codigo = ?', array(ProdutoModel::TIPO_PRODUTO, $codigo));
            $view->setMessage(new Message('Produto excluído', Message::TYPE_SUCCESS));
        } catch (\PDOException $ex) {
            $view->setMessage(new Message($ex->getMessage(), Message::TYPE_DANGER));
        } catch (\Exception $ex) {
            Application::logsys(100, $ex->getMessage());
            $view->setMessage(new Message('Erro ao finalizar a operação. Entre em contato com o administrador do sistema.', Message::TYPE_DANGER));
        }
        $this->listagem($view);
    }
}