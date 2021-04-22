<?php

namespace OnePay\SDK\Model;

class Webhook
{
    public $container = [];

    public function __construct(array $data = null)
    {
        $this->container['slug'] = $data['slug'] ?? null;
        $this->container['value'] = $data['value'] ?? null;
    }
    
	public function getSlug()
    {
        return $this->container['slug'];
    }

    public function setSlug($slug)
    {
        $this->container['slug'] = $slug;

        return $this;
    }

	public function getValue()
    {
        return $this->container['value'];
    }

    public function setValue($value)
    {
        $this->container['value'] = $value;

        return $this;
    }
	
}
