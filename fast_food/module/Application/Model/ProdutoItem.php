<?php

namespace Application\Model;

class ProdutoItem
{
    /**
     * @var Produto
     */
    private $produto;

    /**
     * @var Produto
     */
    private $item;

    /**
     * @var float
     */
    private $quantidade;

    /**
     * @var bool
     */
    private $adicional;

    /**
     * @var float
     */
    private $valor;

    /**
     * @return Produto
     */
    public function getProduto()
    {
        return $this->produto;
    }

    /**
     * @param Produto $produto
     */
    public function setProduto(Produto $produto)
    {
        $this->produto = $produto;
    }

    /**
     * @return Produto
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * @param Produto $item
     */
    public function setItem(Produto $item)
    {
        $this->item = $item;
    }

    /**
     * @return float
     */
    public function getQuantidade()
    {
        return $this->quantidade;
    }

    /**
     * @param float $quantidade
     */
    public function setQuantidade($quantidade)
    {
        $this->quantidade = $quantidade;
    }

    /**
     * @return boolean
     */
    public function isAdicional()
    {
        return $this->adicional;
    }

    /**
     * @param boolean $adicional
     */
    public function setAdicional($adicional)
    {
        $this->adicional = $adicional;
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
}