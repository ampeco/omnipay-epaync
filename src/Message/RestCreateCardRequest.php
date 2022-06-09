<?php

namespace Omnipay\EpayNC\Message;

class RestCreateCardRequest extends AbstractRestRequest
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
            'amount' => $this->getAmountInteger(),
            'currency' => $this->getCurrency(),
            'orderId' => $this->getTransactionId(),
            'customer' => [
                'email' => $this->getCard()->getEmail(),
            ],
            'formAction' => 'REGISTER',
            'locale' => $this->getLanguage(),
        ];
    }

    public function getCardReference()
    {
        return $this->getParameter('cardReference');
    }

    /**
     * Endpoint for this request
     * @return string
     */
    protected function getEndpoint()
    {
        return parent::getEndpoint() . '/api-payment/V4/Charge/CreatePaymentOrder';
    }

    /**
     * @inheritdoc
     */
    protected function createResponse($data, $statusCode)
    {
        return $this->response = new RestCreateCardResponse($this, $data);
    }
}
