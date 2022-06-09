<?php

namespace Omnipay\EpayNC\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;

class RestCreateCardResponse extends AbstractResponse implements RedirectResponseInterface
{
    public $liveEndpoint = 'https://epaync.nc/vads-payment/';

    public function getEndpoint()
    {
        return $this->liveEndpoint;
    }

    public function isSuccessful()
    {
        return !empty($this->data['status']) && $this->data['status'] == 'SUCCESS' && $this->getCode() < 400;
    }

    public function isRedirect()
    {
        return true;
    }

    public function getRedirectUrl()
    {
        return $this->data['answer']['paymentURL'];
    }

    public function getRedirectMethod()
    {
        return 'GET';
    }

    public function getRedirectData()
    {
        return $this->data;
    }
}
