<?php

namespace Omnipay\EpayNC\Message;

class RestDeleteCardResponse extends RestResponse
{
    public function isSuccessful()
    {
        return $this->statusCode < 400 && @$this->data['status'] === 'SUCCESS';
    }
}
