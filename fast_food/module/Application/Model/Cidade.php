<?php

namespace Application\Model;

class Cidade
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
     * @var string
     */
    private $uf;

    /**
     * @param int $codigo
     */
    function __construct($codigo)
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
     * @return string
     */
    public function getUf()
    {
        return $this->uf;
    }

    /**
     * @param string $uf
     */
    public function setUf($uf)
    {
        $this->uf = $uf;
    }
}