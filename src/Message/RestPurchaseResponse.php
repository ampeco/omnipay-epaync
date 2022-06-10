<?php

namespace Omnipay\EpayNC\Message;

class RestPurchaseResponse extends RestResponse
{
    /**
     * @inheritdoc
     */
    public function isSuccessful()
    {
        return parent::isSuccessful() && 'SUCCESS' === $this->getData()['status'] && $this->checkOrderStatus();
    }

    public function getTransactionReference()
    {
        if (!$this->isSuccessful()) {
            return null;
        }

        return $this->getData()['answer']['orderDetails']['orderId'];
    }

    private function checkOrderStatus()
    {
        $data = $this->getData();
        if (!isset($data['answer'], $data['answer']['orderStatus'])) {
            return false;
        }

        return 'PAID' === $data['answer']['orderStatus'];
    }

    public function getMessage()
    {
        return $this->data['answer']['errorMessage'] ?? parent::getMessage();
    }
}
