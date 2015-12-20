<?php

namespace Application\Controller;

use Application\Exception\ValidationException;
use Application\Helper\EmptyValidator;
use Application\Helper\Message;
use Application\Helper\RegexValidator;
use Application\Helper\RegexValidatorException;
use Application\Model\ProdutoModel;
use Application\View\ApplicationView;
use Szy\Http\Request;
use Szy\Mvc\Application;

class ComposicaoController extends AdminController
{
    /**
     * @param int $codigo
     * @throws ValidationException
     */
    public function indexAction($codigo = null)
    {
        $view = new ApplicationView($this, 'produto/composicao_index');
        $view->setTitle('Composição do produto');

        $model = new ProdutoModel();
        $produto = $model->row('produto', null, 'tipo = ? AND codigo = ?', array(ProdutoModel::TIPO_PRODUTO, $codigo));
        if ($produto == null) {
            $view->setMessage(new Message('Código do produto inválido', Message::TYPE_DANGER));
            $view->flush();
            return;
        }

        if ($this->getSession()->exists('message')) {
            $view->setMessage($this->getSession()->read('message'));
            $this->getSession()->delete('message');
        }

        $view->setAttribute('produto', $produto);
        $view->setAttribute('itens', $model->itens($produto));
        $view->flush();
    }

    /**
     * @param int $codigoProduto
     */
    public function cadastrarAction($codigoProduto)
    {
        if (!$this->permissao())
            return;

        $view = new ApplicationView($this, 'produto/composicao_formulario');
        $view->setTitle('Adicionar item ao produto');
        $view->setAttribute('acao', 'cadastrar');

        $model = new ProdutoModel();
        $produto = $model->row('produto', null, 'tipo = ? AND codigo = ?', array(ProdutoModel::TIPO_PRODUTO, $codigoProduto));
        if ($produto == null) {
            $view->setMessage(new Message('Código do produto inválido', Message::TYPE_DANGER));
            $view->flush();
            return;
        }

        // Armazena o valor do código do produto na variável "produto" da view para funcionar o botão "listagem"
        $view->data['produto'] = $codigoProduto;

        $res_itens = $model->select('produto', null, 'tipo = ?', array(ProdutoModel::TIPO_ITEM));
        $view->setAttribute('res_itens', $res_itens);

        if ($this->isMethod(Request::METHOD_POST)) {

            $item = $this->getPostField('item');

            $quantidade = $this->getPostField('quantidade');

            $valor = $this->getPostField('valor');
            $valor->addValidator(new RegexValidator('/[0-9]+\.[0-9]+$/', 'Campo valor inválido'));

            $adicional = $this->getPostField('adicional');

            try {
                if ($item->getValue() == null || $item->getValue() == '0')
                    throw new RegexValidatorException('Selecione um produto na lista');

                if ($quantidade->getValue() == null)
                    throw new RegexValidatorException('Campo quantidade inválido');

                $valor->validate();

                $r = $model->row('produto_item', null, 'produto = ? AND item = ?', array($produto->codigo, $item->getValue()));
                if ($r != null)
                    throw new RegexValidatorException('Este item já está incluído neste produto');

                $model->insert('produto_item', array(
                    'produto' => $produto->codigo,
                    'item' => $item->getValue(),
                    'quantidade' => $quantidade->getValue(),
                    'valor' => $valor->getValue(),
                    'adicional' => intval($adicional->getValue())
                ));

                $this->getSession()->write('message', new Message('Item adicionado com sucesso', Message::TYPE_SUCCESS));
                $this->response->sendRedirect('/estoque/produtos/composicao/' . $codigoProduto);
            } catch (RegexValidatorException $ex) {
                $view->setMessage(new Message($ex->getMessage(), Message::TYPE_DANGER));
            } catch (\Exception $ex) {
                Application::logsys(100, $ex->getMessage() . ' at line: ' . $ex->getLine() . ' on  file: ' . $ex->getFile());
                $view->setMessage(new Message('Erro ao realizar operação. Entre em contato com o administrador do sistema', Message::TYPE_DANGER));
            }

        }

        $view->flush();
    }

    /**
     * @param int $codigoProduto
     * @param int $codigoItem
     */
    public function alterarAction($codigoProduto, $codigoItem)
    {
        if (!$this->permissao())
            return;

        $view = new ApplicationView($this, 'produto/composicao_formulario');
        $view->setTitle('Alterar item do produto');

        $model = new ProdutoModel();
        $produto = $model->item($codigoProduto, $codigoItem);
        if ($produto == null) {
            $view->setMessage(new Message('Código do produto inválido', Message::TYPE_DANGER));
            $view->flush();
            return;
        }

        if ($this->isMethod(Request::METHOD_POST)) {

            $view->data['nome'] = $produto->nome;

            $quantidade = $this->getPostField('quantidade');

            $valor = $this->getPostField('valor');
            $valor->addValidator(new RegexValidator('/[0-9.]+/', 'Campo valor inválido'));

            $adicional = $this->getPostField('adicional');

            try {
                if ($quantidade->getValue() == null)
                    throw new RegexValidatorException('Campo quantidade inválido');

                $valor->validate();

                $arguments = array(
                    'quantidade' => $quantidade->getValue(),
                    'valor' => $valor->getValue(),
                    'adicional' => intval($adicional->getValue())
                );
                $model->update('produto_item', $arguments, 'produto = ? AND item = ?', array($codigoProduto, $codigoItem));

                $this->getSession()->write('message', new Message('Item alterado com sucesso', Message::TYPE_SUCCESS));
                $this->response->sendRedirect('/estoque/produtos/composicao/' . $codigoProduto);
            } catch (RegexValidatorException $ex) {
                $view->setMessage(new Message($ex->getMessage(), Message::TYPE_DANGER));
            } catch (\Exception $ex) {
                Application::logsys(100, $ex->getMessage());
                $view->setMessage(new Message('Erro ao realizar operação. Entre em contato com o administrador do sistema', Message::TYPE_DANGER));
            }
        } else {
            $view->data = (array) $produto;
        }

        $view->flush();
    }

    public function excluirAction($codigoProduto, $codigoItem)
    {
        if (!$this->permissao())
            return;

        $model = new ProdutoModel();
        $item = $model->row('produto_item', null, 'produto = ? AND item = ?', array($codigoProduto, $codigoItem));

        try {
            if ($item == null)
                throw new ValidationException('Código do produto inválido');

            $model->delete('produto_item', 'produto = ? AND item = ?', array($codigoProduto, $codigoItem));
            $this->getSession()->write('message', new Message('Item excluído com sucesso', Message::TYPE_SUCCESS));
        } catch (ValidationException $ex) {
            $this->getSession()->write('message', new Message($ex->getMessage(), Message::TYPE_DANGER));
        } catch (\Exception $ex) {
            Application::logsys(100, $ex->getMessage());
            $this->getSession()->write('message', new Message('Erro ao realizar operação. Entre em contato com o administrador do sistema', Message::TYPE_DANGER));
        }
        $this->response->sendRedirect('/estoque/produtos/composicao/' . $codigoProduto);
    }
}