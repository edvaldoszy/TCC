<?php

namespace Application\Model;

class Contato
{
    /**
     * @var int
     */
    private $codigo;

    /**
     * @var string
     */
    private $telefone;

    /**
     * @var Cliente
     */
    private $cliente;

    /**
     * Contato constructor.
     * @param int $codigo
     */
    public function __construct($codigo)
    {
        $this->codigo = $codigo;
    }

    /**
     * @return int
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * @param int $codigo
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
    }

    /**
     * @return string
     */
    public function getTelefone()
    {
        return $this->telefone;
    }

    /**
     * @param string $telefone
     */
    public function setTelefone($telefone)
    {
        $this->telefone = $telefone;
    }

    /**
     * @return Cliente
     */
    public function getCliente()
    {
        return $this->cliente;
    }

    /**
     * @param Cliente $cliente
     */
    public function setCliente($cliente)
    {
        $this->cliente = $cliente;
    }
}