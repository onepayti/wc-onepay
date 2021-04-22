<?php

namespace OnePay\SDK\Model;

class Cliente
{
    public $container = [];

    public function __construct(array $data = null)
    {
        $this->container['nome'] = $data['nome'] ?? null;
        $this->container['cpf'] = $data['document'] ?? null;
        $this->container['dataNascimento'] = $data['dataNascimento'] ?? null;
        $this->container['email'] = $data['email'] ?? null;
        $this->container['celular'] = $data['celular'] ?? null;
    }

    public function getNome()
    {
        return $this->container['nome'];
    }

    public function setNome($nome)
    {
        $this->container['nome'] = $nome;

        return $this;
    }

    public function getCPF()
    {
        return $this->container['cpf'];
    }

    public function setCPF($cpf)
    {
        $this->container['cpf'] = $cpf;

        return $this;
    }

    public function getDataNascimento()
    {
        return $this->container['dataNascimento'];
    }

    public function setDataNascimento($dataNascimento)
    {
        $this->container['dataNascimento'] = $dataNascimento;

        return $this;
    }
	
    public function getEmail()
    {
        return $this->container['email'];
    }

    public function setEmail($email)
    {
        $this->container['email'] = $email;

        return $this;
    }

    public function getCelular()
    {
        return $this->container['celular'];
    }

    public function setCelular($celular)
    {
        $this->container['celular'] = $celular;

        return $this;
    }
}
