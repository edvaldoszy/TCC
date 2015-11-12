<?php

namespace Application\Model;

class Endereco
{
    /**
     * @var int
     */
    private $codigo;

    /**
     * @var string
     */
    private $logradouro;

    /**
     * @var int
     */
    private $numero;

    /**
     * @var string
     */
    private $bairro;

    /**
     * @var string
     */
    private $lat, $lng;

    /**
     * @var Cidade
     */
    private $cidade;

    /**
     * @var Cliente
     */
    private $cliente;

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
    public function getLogradouro()
    {
        return $this->logradouro;
    }

    /**
     * @param string $logradouro
     */
    public function setLogradouro($logradouro)
    {
        $this->logradouro = $logradouro;
    }

    /**
     * @return int
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * @param int $numero
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;
    }

    /**
     * @return string
     */
    public function getBairro()
    {
        return $this->bairro;
    }

    /**
     * @param string $bairro
     */
    public function setBairro($bairro)
    {
        $this->bairro = $bairro;
    }

    /**
     * @return string
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * @param string $lat
     */
    public function setLat($lat)
    {
        $this->lat = $lat;
    }

    /**
     * @return string
     */
    public function getLng()
    {
        return $this->lng;
    }

    /**
     * @param string $lng
     */
    public function setLng($lng)
    {
        $this->lng = $lng;
    }

    /**
     * @return Cidade
     */
    public function getCidade()
    {
        return $this->cidade;
    }

    /**
     * @param Cidade $cidade
     */
    public function setCidade($cidade)
    {
        $this->cidade = $cidade;
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