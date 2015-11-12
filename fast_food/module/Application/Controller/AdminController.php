<?php

namespace Application\Controller;

use Application\Helper\EmailValidator;
use Application\Helper\RegexValidator;
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
            $this->response->sendRedirect('/login');
            exit;
        }

        $this->usuario = $this->getSession()->read('usuario');
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
