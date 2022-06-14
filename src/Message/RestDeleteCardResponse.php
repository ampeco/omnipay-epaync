<?php

namespace Omnipay\EpayNC\Message;

class RestDeleteCardResponse extends RestResponse
{
    public function isSuccessful()
    {
        return $this->statusCode < 400 && @$this->data['status'] === 'SUCCESS';
    }

    public function getMessage()
    {
        return $this->data['answer']['errorMessage'] ?? parent::getMessage();
    }
}
