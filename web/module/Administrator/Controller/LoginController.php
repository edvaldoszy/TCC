<?php

namespace Administrator\Controller;

use Administrator\Helper\Output;
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
     * @param string $method
     * @return View
     */
    public function indexAction($method = null)
    {
        $view = new AdministratorView('login/index');
        $view->setTitle('Fazer login');

        if ($this->isPost()) {
            $login = $this->getPost('login', FILTER_SANITIZE_STRING);
            $senha = $this->getPost('senha', FILTER_SANITIZE_STRING);

            try {
                $usuario = $this->validar($login, $senha);

                if ($method == 'json') {
                    $output = new Output();
                    $output->code = Output::CODE_OK;
                    $output->data = $usuario;
                    return $output;
                }

                $this->getSession()->write('usuario_logado', $usuario);
                $this->redirect('/admin');
            } catch (ValidationException $ex) {
                if ($method == 'json') {
                    $output = new Output();
                    $output->code = Output::CODE_ERR;
                    $output->message = $ex->getMessage();

                    return $output;
                }
                $view->setValue('message', new Message($ex->getMessage(), Message::MSG_ERROR));
                $view->setValue('login', $login);
                $view->setValue('senha', $senha);
            } catch (\PDOException $ex) {
                if ($method == 'json') {
                    $output = new Output();
                    $output->code = Output::CODE_ERR;
                    $output->message = $ex->getMessage();

                    return $output;
                }
                $view->setValue('message', new Message($ex->getMessage(), Message::MSG_ERROR));
                $view->setValue('login', $login);
                $view->setValue('senha', $senha);
            }
        }
        return $view;
    }

    public function sairAction()
    {
        $this->getSession()->delete('usuario_logado');

        $view = new AdministratorView('login/index');
        $view->setTitle('Sair');
        return $view;
    }

    private function validar($login, $senha)
    {
        $va = new Validator();
        $va->value($login)->valid('Preencha o campo login');
        $va->value($senha)->valid('Preencha o campo senha');

        $model = new UsuarioModel();
        $res = $model->select(array('codigo', 'nome', 'email', 'login', 'admin'), 'login = ? AND senha = ?', array($login, md5($senha)));

        if ($res->count() < 1)
            throw new ValidationException('Login ou senha inválida');

        return $res->first();
    }

}