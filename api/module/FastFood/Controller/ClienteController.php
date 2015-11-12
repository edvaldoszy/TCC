<?php

namespace FastFood\Controller;

use FastFood\Exception\ValidationException;
use FastFood\Helper\EmailValidator;
use FastFood\Helper\EmptyValidator;
use FastFood\Helper\JSONResponse;
use FastFood\Helper\PhoneValidator;
use FastFood\Helper\RegexValidator;
use FastFood\Helper\RegexValidatorException;
use FastFood\Model\ClienteModel;
use Szy\Http\Request;
use Szy\Mvc\Controller\AbstractController;
use Szy\Mvc\Model\ModelException;

class ClienteController extends AbstractController
{
    /**
     * @var ClienteModel
     */
    private $model;

    public function init()
    {
        $this->model = new ClienteModel();
    }

    public function indexAction($codigo = null)
    {
        switch ($this->request->getMethod()) {
            case self::METHOD_GET:
                $this->doGetCliente($codigo);
                break;

            case self::METHOD_POST:
                $this->doPostCliente($codigo);
                break;
        }
    }

    public function contatosAction($codigoCliente, $codigoContato)
    {
        if ($this->isMethod(Request::METHOD_DELETE)) {

            $model = new ClienteModel();
            try {
                if (empty($codigoContato))
                    throw new ValidationException('Codigo do contato inválido');

                $model->delete('contato', 'codigo = ?', array($codigoContato));
                $this->response->setStatus(200);
            } catch (ModelException $ex) {
                $this->response->setStatus(500, $ex->getMessage());
            } catch (ValidationException $ex) {
                $this->response->setStatus(400, $ex->getMessage());
            }
            return;
        }

        if (!$this->isMethod(Request::METHOD_POST)) {
            $this->response->setStatus(400);
            return;
        }

        $telefone = $this->getPostField('telefone');
        $telefone->addValidator(new PhoneValidator('Telefone inválido'));

        $model = new ClienteModel();
        try {

            if (empty($codigoCliente))
                throw new ValidationException("Código do cliente inválido");

            $telefone->validate();
            $arguments = array(
                'telefone' => $telefone->getValue()
            );

            if ($this->getParam('acao') == 'novo') {
                $arguments['cliente'] = $codigoCliente;
                $model->insert('contato', $arguments);
            } else {
                $model->update('contato', $arguments, 'codigo = ?', array($codigoContato));
            }

        } catch (RegexValidatorException $ex) {
            $this->response->setStatus(400, $ex->getMessage());
        } catch (ModelException $ex) {
            $this->response->setStatus(500, $ex->getMessage());
        } catch (ValidationException $ex) {
            $this->response->setStatus(500, $ex->getMessage());
        }
    }

    public function enderecosAction($codigoCliente, $codigoEndereco)
    {
        if ($this->isMethod(Request::METHOD_GET)) {
            $model = new ClienteModel();

            $json = new JSONResponse($this);

            $cliente = $model->cliente($codigoCliente);
            $json->set('cliente', $cliente);
            $json->set('enderecos', $model->enderecos($cliente));
            $json->flush();
            return;
        }

        if ($this->isMethod(Request::METHOD_DELETE)) {

            $model = new ClienteModel();
            try {
                if (empty($codigoEndereco))
                    throw new ValidationException('Codigo do endereço inválido');

                $model->delete('endereco', 'codigo = ?', array($codigoEndereco));
                $this->response->setStatus(200);
            } catch (ModelException $ex) {
                $this->response->setStatus(500, $ex->getMessage());
            } catch (ValidationException $ex) {
                $this->response->setStatus(400, $ex->getMessage());
            }
            return;
        }

        if (!$this->isMethod(Request::METHOD_POST)) {
            $this->response->setStatus(400);
            return;
        }

        $logradouro = $this->getPostField('logradouro');
        $logradouro->addValidator(new EmptyValidator('Informe uma avenida, rua ou logradouro'));

        $numero = $this->getPostField('numero');
        $numero->addValidator(new EmptyValidator('Informe o número do endereço'));

        $bairro = $this->getPostField('bairro');
        $bairro->addValidator(new EmptyValidator('Informe o nome do bairro'));

        $cidade = $this->getPostField('cidade');

        $model = new ClienteModel();
        try {

            if (empty($codigoCliente))
                throw new ValidationException("Código do cliente inválido");

            $logradouro->validate();
            $numero->validate();
            $bairro->validate();
            $cidade->validate();

            $arguments = array(
                'logradouro' => $logradouro->getValue(),
                'numero' => $numero->getValue(),
                'bairro' => $bairro->getValue(),
                'cidade' => $cidade->getValue()
            );

            if ($this->getParam('acao') == 'novo') {
                $arguments['cliente'] = $codigoCliente;
                $model->insert('endereco', $arguments);
            } else {
                $model->update('endereco', $arguments, 'codigo = ?', array($codigoEndereco));
            }

        } catch (RegexValidatorException $ex) {
            $this->response->setStatus(400, $ex->getMessage());
        } catch (ModelException $ex) {
            $this->response->setStatus(500, $ex->getMessage());
        } catch (ValidationException $ex) {
            $this->response->setStatus(500, $ex->getMessage());
        }
    }

    private function doGetCliente($codigo)
    {
        $cliente = $this->model->cliente($codigo);

        $data = array(
            'cliente' => $cliente,
            'enderecos' => $this->model->enderecos($cliente),
            'contatos' => $this->model->contatos($cliente)
        );

        $json = new JSONResponse($this);
        $json->set('conta', $data);
        $json->flush();
    }

    public function loginAction()
    {
        if ($this->request->getMethod() == self::METHOD_POST) {

            $email = $this->getPostField('email');
            $email->addValidator(new EmailValidator('Endereço de e-mail inválido'));

            $senha = $this->getPostField('senha');
            $senha->addValidator(new RegexValidator('/.+/i', 'Preencha o campo senha'));

            $json = new JSONResponse($this);
            try {
                $email->validate(true);
                $senha->validate(true);

                $cliente = $this->model->verificar($email->getValue(), $senha->getValue());
                $this->response->setStatus(200);
                $json->set('cliente', $cliente);
            } catch (RegexValidatorException $ex) {
                $this->response->setStatus(400, $ex->getMessage());
            } catch (ModelException $ex) {
                $this->response->setStatus(401, $ex->getMessage());
            } catch (\PDOException $ex) {
                $this->response->setStatus(500, $ex->getMessage());
            }
            //$this->response->setStatus(406, 'Deu certo não cara :(');
            $json->flush();
        }
    }

    // Atualiza as informações do cliente
    private function doPostCliente($codigo)
    {
        if (empty($codigo))
            throw new ModelException("Informe o codigo do cliente");

        $nome = $this->getPostField('nome');
        $nome->addValidator(new EmptyValidator('Preencha o campo nome'));

        $email = $this->getPostField('email');
        $email->addValidator(new EmailValidator('Endereço de e-mail inválido'));

        $senha = $this->getPostField('senha');

        $model = new ClienteModel();
        $json = new JSONResponse($this);
        try {
            $nome->validate();
            $email->validate();

            $arguments = array(
                'nome' => $nome->getValue(),
                'email' => $email->getValue()
            );

            if ($senha->getValue() != null)
                $arguments['senha'] = $senha->getValue();

            $model->update('cliente', $arguments, 'codigo = ?', array($codigo));

            $this->response->setStatus(200);
        } catch (\PDOException $ex) {
            $this->response->setStatus(500, $ex->getMessage());
        } catch (ValidationException $ex) {
            $this->response->setStatus(400, $ex->getMessage());
        }
        $json->flush();
    }

    private function getData($cliente)
    {
        $nome = $this->getPostField('nome');
        $nome->addValidator(new RegexValidator('/\w+/i', 'Preencha o campo nome'));
        $cliente->nome = $nome->getValue();

        $email = $this->getPostField('email');
        $email->addValidator(new RegexValidator('/\w+/i', 'Preencha o campo e-mail'));
        $cliente->email = $email->getValue();

        $senha = $this->getPostField('senha');
        if ($senha->getValue() != '')
            $cliente->senha = $senha->getValue();
    }

    public function imagemAction() {
        var_dump($_POST['imagem']);
        exit;
    }
}