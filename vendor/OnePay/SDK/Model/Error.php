<?php

namespace OnePay\SDK\Model;

class Error
{
    public $container = [];

    public function __construct(array $data = null)
    {
        $this->container['type'] = $data['type'] ?? null;
        $this->container['category'] = $data['category'] ?? null;
        $this->container['message'] = $data['message'] ?? null;
    }

    public function getType()
    {
        return $this->container['type'];
    }

    public function setType($type)
    {
        $this->container['type'] = $type;

        return $this;
    }

    public function getCategory()
    {
        return $this->container['category'];
    }

    public function setCategory($category)
    {
        $this->container['category'] = $category;

        return $this;
    }

    public function getMessage()
    {
        return $this->container['message'];
    }

    public function setMessage($message)
    {
        $this->container['message'] = $message;

        return $this;
    }
}
