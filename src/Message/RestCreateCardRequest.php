<?php

namespace Omnipay\EpayNC\Message;

use Illuminate\Support\Facades\Http;

class RestCreateCardRequest extends AbstractRestRequest
{
    /**
     * @return array
     */
    public function getData()
    {
        return  [
            'amount' => $this->getAmountInteger(),
            'currency' => 'XPF',
            'orderId' => $this->getTransactionId(),
            'customer' => [
                'email' => $this->getCard()->getEmail(),
            ],
            'formAction' => 'REGISTER'
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
        //return $this->response = new RestResponse($this, $data, $statusCode);
        return $this->response = new RedirectToGatewayResponse($this, $data, $statusCode);
    }
}
