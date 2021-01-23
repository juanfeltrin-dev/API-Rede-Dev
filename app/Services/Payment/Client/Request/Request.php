<?php


namespace App\Services\Payment\Client\Request;


use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use App\Services\Payment\Client\Response\Interfaces\ResponseInterface;

class Request
{
    const METHOD_POST   = 'POST';
    const METHOD_PUT    = 'PUT';
    const METHOD_GET    = 'GET';
    const METHOD_DELETE = 'DELETE';

    /**
     * @var string
     */
    private $_baseUrl;

    /**
     * @var array
     */
    private $_options;

    /**
     * @var string
     */
    private $_method;

    /**
     * @var string
     */
    private $_service;

    /**
     * @var ResponseInterface
     */
    private $_response;

    /**
     * @return string
     */
    public function getBaseUrl(): string
    {
        return $this->_baseUrl;
    }

    /**
     * @param string $baseUrl
     */
    public function setBaseUrl(string $baseUrl): void
    {
        $this->_baseUrl = $baseUrl;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->_options;
    }

    /**
     * @param array $options
     */
    public function setOptions(array $options): void
    {
        $this->_options = $options;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->_method;
    }

    /**
     * @param string $method
     */
    public function setMethod(string $method): void
    {
        $this->_method = $method;
    }

    /**
     * @return string
     */
    public function getService(): string
    {
        return $this->_service;
    }

    /**
     * @param string $service
     */
    public function setService(string $service): void
    {
        $this->_service = $service;
    }

    /**
     * @return ResponseInterface
     */
    public function getResponse(): ResponseInterface
    {
        return $this->_response;
    }

    /**
     * @param ResponseInterface $response
     */
    public function setResponse(ResponseInterface $response): void
    {
        $this->_response = $response;
    }

    /**
     * @return mixed
     * @throws Exception
     */
    public function build()
    {
        try {
            if (is_null($this->getBaseUrl()) || empty($this->getOptions())) {
                throw new Exception("Base url or options cannot be null or empty.");
            }

            $client = new Client([
                'base_uri' => $this->getBaseUrl()
            ]);

            $response = $client->request($this->getMethod(), $this->getService(), $this->getOptions());

            return $this->getResponse()->build($response);
        } catch (ClientException $clientException) {
            throw new Exception($clientException->getResponse()->getBody()->getContents());
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }
}
