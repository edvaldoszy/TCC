<?php

namespace Application\Model;

class Categoria
{
    /**
     * @var int
     */
    private $codigo;

    /**
     * @var string
     */
    private $nome;

    /**
     * Categoria constructor.
     * @param int $codigo
     * @param string $nome
     */
    public function __construct($codigo, $nome)
    {
        $this->codigo = $codigo;
        $this->nome = $nome;
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
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param string $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    /**
     * @return array
     */
    public function getVars()
    {
        return get_object_vars($this);
    }


}