<?php

namespace Omnipay\EpayNC\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;

class RedirectToGatewayResponse extends AbstractResponse implements RedirectResponseInterface
{
    public $liveEndpoint = 'https://epaync.nc/vads-payment/';

    public function getEndpoint()
    {
        return $this->liveEndpoint;
    }

    public function isSuccessful()
    {
        return false;
    }

    public function isRedirect()
    {
        return true;
    }

    public function getRedirectUrl()
    {
        return $this->getEndpoint();
    }

    public function getRedirectMethod()
    {
        return 'POST';
    }

    public function getRedirectData()
    {
        return $this->data;
    }
}
