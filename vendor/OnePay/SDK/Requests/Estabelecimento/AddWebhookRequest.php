<?php

namespace OnePay\SDK\Requests\Pagamento;

use OnePay\SDK\Requests\AbstractRequest;

class AddWebhookRequest extends AbstractRequest
{
    public function run()
    {
        $url = parent::getEnvironment()->getApiURL();
        $data = parent::getData();
		
        parent::setHttpBody($data->container);		
		parent::setResourcePath('estabelecimentos/configuracoes');
        parent::getClient()->getConfig()->setHost($url);

        return parent::sendRequest();
    }
}
