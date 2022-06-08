<?php

namespace Omnipay\EpayNC\Message;

use Omnipay\Common\Exception\InvalidResponseException;
use Omnipay\Common\Message\AbstractRequest as OmniPayAbstractRequest;
use Omnipay\Common\Message\ResponseInterface;
use Omnipay\EpayNC\CommonParameters;

abstract class AbstractRestRequest extends OmniPayAbstractRequest
{
    use CommonParameters;

    /**
     * Rest API endpoint
     * @var string
     */
    protected $liveEndPoint = 'https://epaync.nc';

    /**
     * Send data to payzen Rest API as a GET or a POST
     * it depends on the need of the request
     * @param array $data
     * @throws InvalidResponseException
     * @return ResponseInterface
     */
    public function sendData($data)
    {
        if ($this->getHttpMethod() == 'GET') {
            $httpResponse = $this->httpClient->request(
                $this->getHttpMethod(),
                $this->getEndpoint() . '?' . http_build_query($data),
                [
                    'Accept' => 'application/json',
                    'Authorization' => 'Basic ' . $this->getBearerToken(),
                    'Content-type' => 'application/json',
                ]
            );
        } else {
            $httpResponse = $this->httpClient->request(
                $this->getHttpMethod(),
                $this->getEndpoint(),
                [
                    'Accept' => 'application/json',
                    'Authorization' => 'Basic ' . $this->getBearerToken(),
                    'Content-type' => 'application/json',
                ],
                $this->toJSON($data)
            );
        }

        try {
            $body = $httpResponse->getBody()->getContents();
            $jsonToArrayResponse = !empty($body) ? json_decode($body, true) : [];

            return $this->response = $this->createResponse($jsonToArrayResponse, $httpResponse->getStatusCode());
        } catch (\Exception $e) {
            throw new InvalidResponseException(
                'Error communicating with payment gateway: ' . $e->getMessage(),
                $e->getCode()
            );
        }
    }

    /**
     * Use to define the request verb
     * @return string
     */
    protected function getHttpMethod()
    {
        return 'POST';
    }

    /**
     * @return string
     */
    protected function getEndpoint()
    {
        return $this->liveEndPoint;
    }

    /**
     * Convert a set of data into a JSON
     * @param array $data
     * @param int $options
     * @return string
     */
    protected function toJSON(array $data, $options = 0)
    {
        return json_encode($data, $options | JSON_UNESCAPED_SLASHES);
    }

    /**
     * Allow the use of custom Response
     * @param array $data
     * @param int $statusCode
     */
    abstract protected function createResponse($data, $statusCode);

    /**
     * Make the Authorization token for PayZen Rest API
     * @return string
     */
    private function getBearerToken()
    {
        $username = $this->getUsername();
        $password = $this->getPassword();

        return base64_encode(sprintf(
            '%s:%s',
            $username,
            $password
        ));
    }

    /**
     * @param string
     * @return bool
     */
    public function hasParameter($key)
    {
        return $this->parameters->has($key);
    }

    /**
     * @return bool
     */
    public function getWithForm()
    {
        return $this->getParameter('withForm');
    }

    /**
     * @param bool
     * @return self
     */
    public function setWithForm($value)
    {
        return $this->setParameter('withForm', $value);
    }

    public function setLanguage($value): AbstractRestRequest
    {
        return $this->setParameter('language', $value);
    }

    public function getLanguage()
    {
        return $this->getParameter('language');
    }
}
