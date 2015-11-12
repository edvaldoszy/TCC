<?php

namespace Application\Model;

class Produto
{
    const TIPO_PRODUTO = 2;
    const TIPO_ITEM = 1;

    /**
     * @var int
     */
    private $codigo;

    /**
     * @var string
     */
    private $nome;

    /**
     * @var float
     */
    private $valor;

    /**
     * @var string
     */
    private $tipo;

    /**
     * @var string
     */
    private $ativo;

    /**
     * @var Categoria
     */
    private $categoria;

    /**
     * @var string
     */
    private $descricao;

    /**
     * Produto constructor.
     * @param int $codigo
     * @param string $nome
     */
    public function __construct($codigo = 0, $nome = null)
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
     * @return float
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * @param float $valor
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
    }

    /**
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * @param string $tipo
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }

    /**
     * @return string
     */
    public function getAtivo()
    {
        return $this->ativo;
    }

    /**
     * @param string $ativo
     */
    public function setAtivo($ativo)
    {
        $this->ativo = $ativo;
    }

    /**
     * @return Categoria
     */
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * @param Categoria $categoria
     */
    public function setCategoria($categoria)
    {
        $this->categoria = $categoria;
    }

    /**
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * @param string $descricao
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }

    /**
     * @return array
     */
    public function getVars()
    {
        return get_object_vars($this);
    }
}