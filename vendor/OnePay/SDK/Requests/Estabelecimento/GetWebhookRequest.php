<?php

namespace OnePay\SDK\Requests\Pagamento;

use OnePay\SDK\Requests\AbstractRequest;

class GetWebhookRequest extends AbstractRequest
{
    public function run()
    {
        $url = parent::getEnvironment()->getApiURL();
        $slug = parent::getData()->getSlug();

		parent::setMethod('GET');
		parent::setResourcePath('estabelecimentos/configuracao/' . $slug);
        parent::getClient()->getConfig()->setHost($url);

        return parent::sendRequest();
    }
}
