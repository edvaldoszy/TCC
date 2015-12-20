<?php

namespace Application\Controller;

use Application\Exception\ValidationException;
use Application\Helper\Message;
use Application\Helper\RegexValidatorException;
use Application\Model\ClienteModel;
use Application\View\ApplicationView;
use Eventviva\ImageResize;
use Szy\Http\Request;
use Szy\Mvc\Model\ModelException;
use Szy\Mvc\View\View;
use Szy\Util\DateTime;

class ClienteController extends AdminController
{
    public function uploadAction()
    {
        if (!$this->isMethod(Request::METHOD_POST))
            return;

        $session = $this->getSession();
        $upload = $_FILES['imagem'];
        $date = new DateTime();

        $imagem = new \StdClass();
        $imagem->caminho = '/upload/clientes/' . $date->format('Ymdhis') . strrchr($upload['name'], '.');

        // Faz upload da imagem em um diretório e armazena o endereço na sessão
        // Util caso o usuário atualize a página, ele não perde a imagem enviada
        move_uploaded_file($upload['tmp_name'], PUBLIC_PATH . $imagem->caminho);
        $session->write('imagem', $imagem);
        exit(json_encode($imagem));
    }

    private function listagem(View $view, $pagina = 1)
    {
        $view->setTitle('Clientes');

        $message = $this->getSession()->read('message');
        if ($message != null) {
            $view->setMessage($message);
            $this->getSession()->delete('message');
        }
        if ($this->getSession()->read('imagem') != null) {
            $caminho = $this->getSession()->read('imagem')->caminho;
            unlink(PUBLIC_PATH . $caminho);
            $this->getSession()->delete('imagem');
        }

        $model = new ClienteModel();
        $view->setAttribute('clientes', $model->listar($pagina));
        $view->flush();
    }

    /**
     * @param int $pagina
     */
    public function indexAction($pagina = null)
    {
        $view = new ApplicationView($this, 'cliente/index');
        $this->listagem($view, $pagina);
    }

    public function cadastrarAction()
    {
        $view = new ApplicationView($this, 'cliente/formulario');
        $view->setTitle('Cadastrar cliente');
        $view->data['imagem'] = '/upload/clientes/sem_imagem.png?w=160&h=160';

        // Verifica se existe alguma imagem na sessão e envia para a tela
        $session = $this->getSession();
        if ($session->read('imagem') != null)
            $view->data['imagem'] = $session->read('imagem')->caminho . '?w=160&h=160';

        $model = new ClienteModel();
        if ($this->isMethod(Request::METHOD_POST)) {

            $nome = $this->getNome();
            $email = $this->getEmail();
            $senha = $this->getSenha();

            try {
                $nome->validate();
                $email->validate();
                $senha->validate();

                $cliente = $model->row('cliente', null, 'email = ?', array($email->getValue()));
                var_dump($cliente);
                if ($cliente != null)
                    throw new RegexValidatorException('Endereço de e-mail já está em uso');

                $arguments = array(
                    'nome' => $nome->getValue(),
                    'email' => $email->getValue(),
                    'senha' => md5($senha->getValue())
                );

                // Verifica se existe alguma imagem na sessão e grava no banco de dados
                if ($session->read('imagem') != null) {
                    $arguments['imagem'] = $session->read('imagem')->caminho;
                    $session->delete('imagem');
                }

                $codigo = $model->insert('cliente', $arguments);
                $this->getSession()->write('message', new Message('Cliente cadastrado com sucesso', Message::TYPE_SUCCESS));
                $this->response->sendRedirect('/clientes/alterar/' . $codigo);
            } catch (RegexValidatorException $ex) {
                $view->setMessage(new Message($ex->getMessage(), Message::TYPE_DANGER));
            }
        }

        $view->flush();
    }

    public function alterarAction($codigo)
    {
        $view = new ApplicationView($this, 'cliente/formulario');
        $view->setTitle('Alterar cliente');
        $view->data['imagem'] = '/upload/clientes/sem_imagem.png?w=160&h=160';
        $view->alterar = true;

        try {
            $session = $this->getSession();
            $model = new ClienteModel();
            $cliente = $model->row('cliente', null, 'codigo = ?', array($codigo));
            if ($cliente == null)
                throw new ValidationException('Cliente não encontrado', 10);

            if ($this->isMethod(Request::METHOD_POST)) {

                $nome = $this->getNome();
                $email = $this->getEmail();
                $senha = $this->getSenha();

                $nome->validate();
                $email->validate();

                $arguments = array(
                    'nome' => $nome->getValue(),
                    'email' => $email->getValue()
                );

                // Verifica se o usuário preencheu o campo senha e altera a senha, senão mantem a antiga
                if ($senha->getValue() != '')
                    $arguments['senha'] = md5($senha->getValue());

                // Verifica se existe alguma imagem na sessão e grava no banco de dados
                if ($session->read('imagem') != null) {
                    $arguments['imagem'] = $session->read('imagem')->caminho;
                    $session->delete('imagem');
                }

                $model->update('cliente', $arguments, 'codigo = ?', array($codigo));
                $view->setMessage(new Message('Cliente alterado com sucesso', Message::TYPE_SUCCESS));
            } else {
                unset($cliente->senha);
                $view->data = (array) $cliente;
            }

            // Verifica se não existe imagem sa sessão
            if ($session->read('imagem') != null) {
                $view->data['imagem'] = $session->read('imagem')->caminho . '?w=160&h=160';
            } else if (!empty($cliente->imagem)) { // Caso contrário, verifica se o usuário tem imagem anexada e exibe
                $view->data['imagem'] = $cliente->imagem . '?w=160&h=160';
            } else {
                $view->data['imagem'] = '/upload/clientes/sem_imagem.png?w=160&h=160';
            }

        } catch (ModelException $ex) {
            $view->setMessage(new Message($ex->getMessage(), Message::TYPE_DANGER));
        } catch (ValidationException $ex) {
            $view->setMessage(new Message($ex->getMessage(), Message::TYPE_DANGER));
        } catch (RegexValidatorException $ex) {
            $view->setMessage(new Message($ex->getMessage(), Message::TYPE_DANGER));
        }

        $view->flush();
    }

    public function excluirAction($codigo)
    {
        $model = new ClienteModel();
        try {
            if (empty($codigo))
                throw new ValidationException('Código do cliente inválido');

            $pedido = $model->row('pedido', null, 'situacao = 1 AND cliente = ?', array($codigo));
            if ($pedido != null)
                throw new ValidationException('Cliente possui pedidos abertos, não pode ser excluído');

            $model->delete('cliente', 'codigo = ?', array($codigo));

            $message = new Message('Cliente excluído com sucesso', Message::TYPE_SUCCESS);
        } catch (ModelException $ex) {
            $message = new Message($ex->getMessage(), Message::TYPE_DANGER);
        } catch (ValidationException $ex) {
            $message = new Message($ex->getMessage(), Message::TYPE_DANGER);
        }
        $this->getSession()->write('message', $message);
        $this->response->sendRedirect('/clientes');
    }
}