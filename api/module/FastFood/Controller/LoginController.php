<?php

namespace FastFood\Controller;

use FastFood\Helper\EmailValidator;
use FastFood\Helper\EmptyValidator;
use FastFood\Helper\JSONResponse;
use FastFood\Helper\RegexValidatorException;
use FastFood\Model\ClienteModel;
use Szy\Http\Request;
use Szy\Mvc\Controller\AbstractController;
use Szy\Mvc\Model\ModelException;

class LoginController extends AbstractController
{
    public function indexAction()
    {
        if (!$this->isMethod(Request::METHOD_POST)) {
            $this->response->setStatus(400);
            return;
        }

        $email = $this->getPostField('email');
        $email->addValidator(new EmailValidator('Endereço de e-mail inválido'));

        $senha = $this->getPostField('senha');
        $senha->addValidator(new EmptyValidator('Preencha o campo senha'));

        $json = new JSONResponse($this);
        try {
            $email->validate();
            $senha->validate();

            $model = new ClienteModel();
            $cliente = $model->verificar($email->getValue(), $senha->getValue());
            $this->response->setStatus(200);
            $this->getSession()->write('cliente', $cliente);
            $json->set('cliente', $cliente);
        } catch (RegexValidatorException $ex) {
            $this->response->setStatus(400, $ex->getMessage());
        } catch (ModelException $ex) {
            $this->response->setStatus(401, $ex->getMessage());
        } catch (\PDOException $ex) {
            $this->response->setStatus(500, $ex->getMessage());
        } finally {
            $json->flush();
        }
    }
}