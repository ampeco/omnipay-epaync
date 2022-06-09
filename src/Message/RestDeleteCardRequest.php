<?php

namespace Omnipay\EpayNC\Message;

class RestDeleteCardRequest extends AbstractRestRequest
{
    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return array
     */
    public function getData()
    {
        return  [
          "paymentMethodToken" => $this->getPaymentMethodToken()//@TODO get the token
        ];
    }

    /**
     * Endpoint for this request
     * @return string
     */
    protected function getEndpoint()
    {
        return parent::getEndpoint() . '/api-payment/V4/Token/Cancel';
    }

    /**
     * @inheritdoc
     */
    protected function createResponse($data, $statusCode)
    {
        return $this->response = new RestDeleteCardResponse($this, $data);
    }

    public function setPaymentMethodToken($value)
    {
        return $this->setParameter('paymentMethodToken', $value);
    }

    public function getPaymentMethodToken()
    {
        return $this->getParameter('paymentMethodToken');
    }

}
