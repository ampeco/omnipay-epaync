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

    public function getMessage(): ?string
    {
        $errorMessages = [];

        if (isset($this->data['answer']['errorMessage']) && $this->data['answer']['errorMessage']) {
            $errorMessages[] = $this->data['answer']['errorMessage'];
        }

        if (isset($this->data['answer']['detailedErrorMessage']) && $this->data['answer']['detailedErrorMessage']) {
            $errorMessages[] = $this->data['answer']['detailedErrorMessage'];
        }

        return implode(' | ', $errorMessages);
    }
}
