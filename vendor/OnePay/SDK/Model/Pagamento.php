<?php

namespace OnePay\SDK\Model;

class Pagamento
{
    const BOLETO = 1;
    const CARTAO_DE_CREDITO = 3;
	
    public $container = [];

    public function __construct(array $data = null)
    {	
		/* removido por limitações da API
		$this->container['tipoPagamentoId'] = $data['tipoPagamentoId'] ?? null;
        $this->container['valor'] = $data['valor'] ?? null;
        $this->container['cartao'] = $data['cartao'] ?? null;
        $this->container['cliente'] = $data['cliente'] ?? null;
        $this->container['endereco'] = $data['endereco'] ?? null;
        $this->container['parcelas'] = $data['parcelas'] ?? null;
        $this->container['dataVencimento'] = $data['dataVencimento'] ?? null;
        $this->container['descricao'] = $data['descricao'] ?? null;
        $this->container['clienteId'] = $data['clienteId'] ?? null;
		*/
    }

    public function getTipoPagamentoId()
    {
        return $this->container['tipoPagamentoId'];
    }

    public function setTipoPagamentoId($tipoPagamentoId)
    {
        $this->container['tipoPagamentoId'] = $tipoPagamentoId;

        return $this;
    }

    public function getValor()
    {
        return $this->container['valor'];
    }

    public function setValor($valor)
    {
        $this->container['valor'] = $valor;

        return $this;
    }

    public function getCliente()
    {
        return $this->container['cliente'];
    }

    public function setCliente($cliente)
    {
        $this->container['cliente'] = $cliente->container;

        return $this;
    }

    public function getCartao()
    {
        return $this->container['cartao'];
    }

    public function setCartao($cartao)
    {
        $this->container['cartao'] = $cartao->container;

        return $this;
    }

    public function getEndereco()
    {
        return $this->container['endereco'];
    }

    public function setEndereco($endereco)
    {
        $this->container['endereco'] = $endereco->container;

        return $this;
    }
	
    public function getParcelas()
    {
        return $this->container['parcelas'];
    }

    public function setParcelas($parcelas)
    {
        $this->container['parcelas'] = $parcelas;

        return $this;
    }

    public function getDataVencimento()
    {
        return $this->container['dataVencimento'];
    }

    public function setDataVencimento($dataVencimento)
    {
        $this->container['dataVencimento'] = $dataVencimento;

        return $this;
    }

    public function getDescricao()
    {
        return $this->container['descricao'];
    }

    public function setDescricao($descricao)
    {
        $this->container['descricao'] = $descricao;

        return $this;
    }

    public function getClienteId()
    {
        return $this->container['clienteId'];
    }

    public function setClienteId($clienteId)
    {
        $this->container['clienteId'] = $clienteId;

        return $this;
    }
}
