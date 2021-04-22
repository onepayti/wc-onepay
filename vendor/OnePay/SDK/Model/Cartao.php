<?php

namespace OnePay\SDK\Model;

class Cartao
{
    public $container = [];

    public function __construct(array $data = null)
    {
        $this->container['titular'] = $data['titular'] ?? null;
        $this->container['numero'] = $data['numero'] ?? null;
        $this->container['codigoSeguranca'] = $data['codigoSeguranca'] ?? null;
        $this->container['validade'] = $data['validade'] ?? null;
    }

    public function getTitular()
    {
        return $this->container['titular'];
    }

    public function SetTitular($titular)
    {
        $this->container['titular'] = $titular;

        return $this;
    }

    public function getNumero()
    {
        return $this->container['numero'];
    }

    public function setStatusNumero($numero)
    {
        $this->container['numero'] = $numero;

        return $this;
    }
	
    public function getCodigoSeguranca()
    {
        return $this->container['codigoSeguranca'];
    }

    public function setCodigoSeguranca($codigoSeguranca)
    {
        $this->container['codigoSeguranca'] = $codigoSeguranca;

        return $this;
    }
	
    public function getValidade()
    {
        return $this->container['validade'];
    }

    public function setValidade($validade)
    {
        $this->container['validade'] = $validade;

        return $this;
    }

}
