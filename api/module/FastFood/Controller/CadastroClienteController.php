<?php

namespace FastFood\Controller;

use FastFood\Exception\ValidationException;
use FastFood\Model\ClienteModel;
use Szy\Mvc\Controller\AbstractController;
use Szy\Mvc\Model\ModelException;

class CadastroClienteController extends AbstractController
{
    public function indexAction()
    {
        $json = json_decode($this->getPost('data'));
        $model = new ClienteModel();

        try {
            $cliente = $json->cliente;

            $row = $model->row('cliente', null, 'email = ?', array($cliente->email));
            if ($row != null)
                throw new ValidationException("Endereco de e-mail ja utilizado");

            $model->insert('cliente',
                array(
                    'nome' => $cliente->nome,
                    'email' => $cliente->email,
                    'senha' => $cliente->senha
                )
            );
            $cliente->codigo = $model->lastID('codigo');

            $endereco = $json->enderecos[0];
            $model->insert('endereco',
                array(
                    'logradouro' => $endereco->logradouro,
                    'numero' => $endereco->numero,
                    'bairro' => $endereco->bairro,
                    'cidade' => $endereco->cidade->codigo,
                    'cliente' => $cliente->codigo
                )
            );

            $contato = $json->contatos[0];
            $model->insert('contato',
                array(
                    'telefone' => $contato->telefone,
                    'cliente' => $cliente->codigo
                )
            );
            $this->response->setStatus(200, 'Cliente cadastrado com sucesso');
        } catch (ModelException $ex) {
            $this->response->setStatus(500, $ex->getMessage());
        } catch (ValidationException $ex) {
            $this->response->setStatus(400, $ex->getMessage());
        }
    }
}