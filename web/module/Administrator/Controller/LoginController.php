<?php

namespace Administrator\Controller;

use Administrator\Model\UsuarioModel;
use Administrator\View\AdministratorView;
use Szy\Mvc\Controller\AbstractController;
use Szy\Mvc\View\View;
use Szy\Util\Message;
use Szy\Validation\Exception\ValidationException;
use Szy\Validation\Validator;

class LoginController extends AbstractController
{
    /**
     * Default controller action
     *
     * @return View
     */
    public function indexAction()
    {
        $view = new AdministratorView('login/index');
        $view->setTitle('Fazer login');

        if ($this->isPost()) {
            $login = $this->getPost('login', FILTER_SANITIZE_STRING);
            $senha = $this->getPost('senha', FILTER_SANITIZE_STRING);

            try {
                $va = new Validator();
                $va->value($login)->valid('Preencha o campo login');
                $va->value($senha)->valid('Preencha o campo senha');

                $this->validate($login, $senha);
                $this->redirect('/admin');
            } catch (ValidationException $ex) {
                $view->setValue('message', new Message($ex->getMessage(), Message::MSG_ERROR));
            }

            $view->setValue('login', $login);
            $view->setValue('senha', $senha);
        }

        return $view;
    }

    public function sairAction()
    {
        $this->getSession()->delete('usuario_logado');

        $view = new AdministratorView('login/index');
        $view->setTitle('Sair');
        $view->setValue('message', new Message('Você saiu do sistema', Message::MSG_INFO));
        return $view;
    }

    private function validate($login, $senha)
    {
        $model = new UsuarioModel();
        $res = $model->select(array('nome', 'email', 'login'), 'login = ? AND senha = ?', array($login, md5($senha)));

        if ($res->count() < 1)
            throw new ValidationException('Usuário ou senha inválida');

        $this->getSession()->write('usuario_logado', $res->first());
    }

}