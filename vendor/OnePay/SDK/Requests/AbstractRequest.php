<?php

namespace OnePay\SDK\Requests;

use OnePay\Client;
use OnePay\Environment;

/**
 * Client for HTTP conections
 *
 * @category Class
 */
abstract class AbstractRequest implements InterfaceRequest
{
    /**
     * Client HTTP
     *
     * @var Client
     */
    protected $client;

    /**
     * Host URL
     *
     * @var Environment
     */
    protected $environment;

    /**
     * Return type
     *
     * @var typeResponse
     */
    protected $typeResponse;

    /**
     * Request endpoint
     *
     * @var resourcePath
     */
    protected $resourcePath;

    /**
     * Request method
     *
     * @var method
     */
    protected $method = 'POST';

    /**
     * Request content
     *
     * @var httpBody
     */
    protected $httpBody;

    /**
     * Request url query params
     *
     * @var queryParams
     */
    protected $queryParams = [];

    /**
     * Request headers params
     *
     * @var headerParams
     */
    protected $headerParams = [];

    /**
     * Request formdata
     *
     * @var formParams
     */
    protected $formParams = [];

    /**
     * Constructor
     *
     * @param Client $client The api client to use
     * @param Environment $environment The host instancie
     */
    public function __construct($data = [], $config = null, $environment = false)
    {
        $this->data = $data;
        $this->client = new Client($config);
        $this->isProductionEnvironment($environment);
    }

    /**
     * Set the data
     *
     * @param array $data set the data
     *
     * @return mixed
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get data
     *
     * @return array get the API data
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set the client
     *
     * @param client $client set the client
     *
     * @return mixed
     */
    public function setClient($client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client
     *
     * @return client get the API client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set the environment
     *
     * @param environment $environment set the environment
     *
     * @return mixed
     */
    public function isProductionEnvironment($environment)
    {
        if ($environment == false) {
            $this->environment = Environment::sandbox();
        } elseif ($environment == true) {
            $this->environment = Environment::production();
        }

        return $this;
    }

    /**
     * Get environment
     *
     * @return environment get the API environment
     */
    public function getEnvironment()
    {
        return $this->environment;
    }

    /**
     * Set api endpoint
     *
     * @param string $endpoint endpoint URL
     */
    public function setResourcePath($resourcePath)
    {
        $this->resourcePath = $resourcePath;

        return $this;
    }

    /**
     * Get api endpoint
     */
    public function getResourcePath()
    {
        return $this->resourcePath;
    }

    /**
     * Set method
     *
     * @param client $method the request method
     */
    public function setMethod($method)
    {
        $this->method = $method;

        return $this;
    }

    /**
     * Get get method
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Set document content
     *
     * @param array $httpBody the content http
     */
    public function setHttpBody($httpBody)
    {
        $this->httpBody = $httpBody;

        return $this;
    }

    /**
     * Get document content
     */
    public function getHttpBody()
    {
        return $this->httpBody;
    }

    /**
     * Set query params
     *
     * @param client $queryParams the query params
     */
    public function setQueryParams($queryParams)
    {
        $this->queryParams = $queryParams;

        return $this;
    }

    /**
     * Get query params
     */
    public function getQueryParams()
    {
        return $this->queryParams;
    }

    /**
     * Set header params
     *
     * @param client $headerParams the header params
     */
    public function addHeaderParams($headerParams)
    {
        $this->headerParams = array_merge($this->headerParams, $headerParams);

        return $this;
    }

    /**
     * Get header params
     */
    public function getHeaderParams()
    {
        return $this->headerParams;
    }

    /**
     * Set form params
     *
     * @param client $formParams the form params
     */
    public function setFormParams($formParams)
    {
        $this->formParams = $formParams;

        return $this;
    }

    /**
     * Get form params
     */
    public function getFormParams()
    {
        return $this->formParams;
    }

    /**
     * Set responde type
     *
     * @param string $typeResponse the response type
     */
    public function setTypeResponse($typeResponse)
    {
        $this->typeResponse = $typeResponse;

        return $this;
    }

    /**
     * Get responde type
     */
    public function getTypeResponse()
    {
        return $this->typeResponse;
    }

    public function sendRequest()
    {
        try {
            list($response, $statusCode, $httpHeader) = $this->client->call(
                $this->getResourcePath(),
                $this->getMethod(),
                $this->getQueryParams(),
                $this->getHttpBody(),
                $this->getHeaderParams(),
                $this->getTypeResponse()
            );

            return $response;
        } catch (Exception $e) {
            throw $e;
        }
    }
}
