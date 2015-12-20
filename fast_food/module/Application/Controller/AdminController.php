<?php

namespace Application\Controller;

use Application\Helper\EmailValidator;
use Application\Helper\Message;
use Application\Helper\RegexValidator;
use Application\View\ApplicationView;
use Szy\Mvc\Controller\AbstractController;

abstract class AdminController extends AbstractController
{
    protected $usuario;

    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * @return boolean
     */
    protected function logado()
    {
        return $this->getSession()->exists('usuario');
    }

    /**
     * @return void
     */
    public function init()
    {
        if (!$this->logado()) {
            $redirect = $this->request->getRequestUri();
            $this->response->sendRedirect('/login?redirect=' . $redirect);
            exit;
        }

        $this->usuario = $this->getSession()->read('usuario');
    }

    public function sessionAction($clear = null)
    {
        if (!empty($clear))
            $this->getSession()->delete('produto_imagens');

        var_dump($this->getSession());
    }

    /**
     * @param Message $message
     */
    protected function setSessionMessage(Message $message)
    {
        $this->getSession()->write('message', $message);
    }

    /**
     * @return Message
     */
    public function getSessionMessage()
    {
        return $this->getSession()->read('message');
    }

    protected function permissao()
    {
        if ($this->usuario->admin != '1') {
            $view = new ApplicationView($this, 'usuario/permissao');
            $view->setTitle('Usuário sem permissão');
            $view->setMessage(new Message('Usuário sem permissão para realizar esta ação', Message::TYPE_DANGER));
            $view->flush();
            return false;
        }
        return true;
    }

    protected function getNome()
    {
        $field = $this->getPostField('nome');
        $field->addValidator(new RegexValidator('/.+/i', 'Preencha o campo nome'));
        return $field;
    }

    protected function getEmail()
    {
        $field = $this->getPostField('email');
        $field->addValidator(new EmailValidator('Endereço de e-mail inválido'));
        return $field;
    }

    protected function getSenha()
    {
        $field = $this->getPostField('senha');
        $field->addValidator(new RegexValidator('/.+/i', 'Preencha o campo senha'));
        return $field;
    }

    protected function getValor()
    {
        $field = $this->getPostField('valor');
        $field->addValidator(new RegexValidator('/[\d.]+/i', 'Preencha o campo valor'));
        return $field;
    }

    protected function getCategoria()
    {
        $field = $this->getPostField('categoria');
        $field->addValidator(new RegexValidator('/[\d]+/i', 'Selecione uma categoria'));
        return $field;
    }
}
