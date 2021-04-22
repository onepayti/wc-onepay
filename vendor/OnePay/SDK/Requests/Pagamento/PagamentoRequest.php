<?php

namespace OnePay\SDK\Requests\Pagamento;

use OnePay\SDK\Requests\AbstractRequest;

class PagamentoRequest extends AbstractRequest
{
    public function run()
    {
        $url = parent::getEnvironment()->getApiURL();
        $data = parent::getData();
		
		parent::setResourcePath('vendas');
        parent::setHttpBody($data->container);
        parent::getClient()->getConfig()->setHost($url);
        parent::setTypeResponse('OnePay\SDK\Model\Venda');

        return parent::sendRequest();
    }
}
