<?php

namespace OnePay\SDK\Model;

class Endereco
{
    public $container = [];

    public function __construct(array $data = null)
    {
        $this->container['logradouro'] = $data['logradouro'] ?? null;
        $this->container['numero'] = $data['document'] ?? null;
        $this->container['cep'] = $data['cep'] ?? null;
        $this->container['cidade'] = $data['cidade'] ?? null;
        $this->container['estado'] = $data['estado'] ?? null;
        $this->container['complemento'] = $data['complemento'] ?? null;
    }

    public function getLogradouro()
    {
        return $this->container['logradouro'];
    }

    public function setLogradouro($logradouro)
    {
        $this->container['logradouro'] = $logradouro;

        return $this;
    }

    public function getNumero()
    {
        return $this->container['numero'];
    }

    public function setNumero($numero)
    {
        $this->container['numero'] = $numero;

        return $this;
    }

    public function getCEP()
    {
        return $this->container['cep'];
    }

    public function setCEP($cep)
    {
        $this->container['cep'] = $cep;

        return $this;
    }
	
    public function getCidade()
    {
        return $this->container['cidade'];
    }

    public function setCidade($cidade)
    {
        $this->container['cidade'] = $cidade;

        return $this;
    }

    public function getEstado()
    {
        return $this->container['estado'];
    }

    public function setEstado($estado)
    {
        $this->container['estado'] = $estado;

        return $this;
    }

    public function getComplemento()
    {
        return $this->container['complemento'];
    }

    public function setComplemento($complemento)
    {
        $this->container['complemento'] = $complemento;

        return $this;
    }
}
