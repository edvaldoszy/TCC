<?php

namespace Application\Controller;

use Application\Helper\EmailValidator;
use Application\Helper\Message;
use Application\Helper\PostField;
use Application\Helper\RegexValidatorException;
use Application\Model\ClienteModel;
use Application\Model\UsuarioModel;
use Application\View\ApplicationView;
use Szy\Http\Request;
use Szy\Mvc\Controller\AbstractController;
use Szy\Mvc\Model\ModelException;

class LoginController extends AbstractController
{
    /**
     * @return PostField
     * @throws RegexValidatorException
     */
    private function getEmail()
    {
        $field = $this->getPostField('email');
        $field->addValidator(new EmailValidator('Endereço de e-mail inválido'));
        return $field;
    }

    /**
     * @return PostField
     * @throws RegexValidatorException
     */
    private function getSenha()
    {
        $field = $this->getPostField('senha');
        $field->validate(true);
        return $field;
    }

    /**
     * @return boolean
     */
    private function logado()
    {
        return $this->getSession()->exists('usuario');
    }

    public function indexAction($sair = false)
    {
        if ($this->logado())
            $this->response->sendRedirect('/admin');

        $redirect = $this->getParam('redirect');
        if ($redirect == null)
            $redirect = '/';

        $view = new ApplicationView($this, 'login/index', 'login');
        $view->redirect = $redirect;
        $view->setTitle('Fazer login');

        $model = new UsuarioModel();

        $email = $this->getEmail();
        $senha = $this->getSenha();
        if ($this->isMethod(Request::METHOD_POST)) {
            try {
                $email->validate(true);
                $senha->validate(true);

                $usuario = $model->row('usuario', null, 'email = ? AND senha = ?', array($email->getValue(), md5($senha->getValue())));
                if ($usuario == null)
                    throw new ModelException('Login ou senha inválida');

                unset($usuario->senha);
                $this->getSession()->write('usuario', $usuario);
                $this->response->sendRedirect($redirect);
            } catch (\Exception $ex) {
                $view->setAttribute('email', $email->getValue());
                $view->setAttribute('senha', $senha->getValue());
                $view->setMessage(new Message($ex->getMessage(), Message::TYPE_DANGER));
            }
        }

        if ($sair) {
            $view->setMessage(new Message('Você saiu do sistema', Message::TYPE_WARNING));
            $view->redirect = '/';
        }

        $view->flush();
    }

    public function senhaAction($emailUrl = null)
    {
        if ($this->logado())
            $this->response->sendRedirect('/index');

        $view = new ApplicationView($this, 'login/senha', 'login');
        $view->setTitle('Recuperar senha');
        $model = new UsuarioModel();

        $view->setAttribute('email', $emailUrl);

        $email = $this->getEmail();
        if ($this->isMethod(Request::METHOD_POST)) {
            try {
                $email->validate(true);

                $usuario = $model->row('usuario', null, 'email = ?', array($email->getValue()));
                if ($usuario == null)
                    throw new ModelException('Endereço de e-mail não consta em nossa base de dados');

                $view->setMessage(new Message('Enviamos um e-mail pra você com as instruções para recuperação da sua senha', Message::TYPE_INFO));
            } catch (\Exception $ex) {
                $view->setAttribute('email', $email->getValue());
                $view->setMessage(new Message($ex->getMessage(), Message::TYPE_DANGER));
            }
        }

        $view->flush();
    }

    public function sairAction()
    {
        $this->getSession()->delete('usuario');
        $this->indexAction(true);
    }
}