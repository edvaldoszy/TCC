<?php

namespace Application\Controller;

use Application\Helper\FieldValidatorException;
use Application\Helper\JSONResponse;
use Application\Helper\RegexValidator;
use Application\Helper\RegexValidatorException;
use Application\Model\Cliente;
use Application\Model\ClienteModel;
use Szy\Http\Request;
use Szy\Mvc\Controller\AbstractController;
use Szy\Mvc\View\View;

class ClienteController extends AbstractController
{
    /**
     * @return View
     */
    public function indexAction()
    {

    }

    public function cadastrarAction()
    {
        if (!$this->isMethod(Request::METHOD_POST))
            return;

        $fdNome = $this->getPostField('nome');
        $fdNome->setValidator(new RegexValidator('/\w+/i', 'Preencha o campo nome'));

        $fdEmail = $this->getPostField('email');
        $fdEmail->setValidator(new RegexValidator('/\w+/i', 'Endereço de e-mail inválido'));

        $fdSenha = $this->getPostField('senha');
        $fdSenha->setValidator(new RegexValidator('/\w+/i', 'Preencha o campo senha'));

        $json = new JSONResponse();
        try {
            $fdNome->validate(true);
            $fdEmail->validate(true);
            $fdSenha->validate(true);

            $cliente = new Cliente();
            $cliente->setNome($fdNome->getValue());
            $cliente->setEmail($fdEmail->getValue());
            $cliente->setSenha($fdSenha->getValue());

            $clienteModel = new ClienteModel();
            $clienteModel->inserir($cliente);

            $json->setStatus(JSONResponse::STATUS_OK);
            $json->setMessage('Cliente cadastrado com sucesso');
            $json->setData($cliente);
        } catch (RegexValidatorException $ex) {
            $json->setStatus(JSONResponse::STATUS_ERROR);
            $json->setMessage($ex->getMessage());
        } finally {
            $this->response->write($json);
        }
    }
}