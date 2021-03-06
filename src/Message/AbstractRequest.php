<?php

namespace Omnipay\EpayNC\Message;

use Omnipay\Common\Message\AbstractRequest as OmniPayAbstractRequest;

/**
 * PayZen Abstract Request
 */
abstract class AbstractRequest extends OmniPayAbstractRequest
{

    public function getMerchantId()
    {
        return $this->getParameter('merchantId');
    }

    public function setMerchantId($value)
    {
        return $this->setParameter('merchantId', $value);
    }

    public function getTransactionDate()
    {
        return $this->getParameter('transactionDate');
    }

    public function setTransactionDate($value)
    {
        return $this->setParameter('transactionDate', $value);
    }

    public function getCertificate()
    {
        return $this->getParameter('certificate');
    }

    public function setCertificate($value)
    {
        return $this->setParameter('certificate', $value);
    }

    public function setSuccessUrl($value)
    {
        return $this->setParameter('successUrl', $value);
    }

    public function getSuccessUrl()
    {
        return $this->getParameter('successUrl');
    }

    public function setCancelUrl($value)
    {
        return $this->setParameter('cancelUrl', $value);
    }

    public function getCancelUrl()
    {
        return $this->getParameter('cancelUrl');
    }

    public function setErrorUrl($value)
    {
        return $this->setParameter('errorUrl', $value);
    }

    public function getErrorUrl()
    {
        return $this->getParameter('errorUrl');
    }

    public function setRefusedUrl($value)
    {
        return $this->setParameter('refusedUrl', $value);
    }

    public function getRefusedUrl()
    {
        return $this->getParameter('refusedUrl');
    }

    public function setPaymentCards($value)
    {
        $this->setParameter('paymentCards', $value);
    }

    public function getPaymentCards()
    {
        return $this->getParameter('paymentCards');
    }

    public function setOrderId($value)
    {
        return $this->setParameter('orderId', $value);
    }

    public function getOrderId()
    {
        return $this->getParameter('orderId');
    }

    public function setUuid($value)
    {
        return $this->setParameter('vads_trans_uuid', $value);
    }

    public function getUuid()
    {
        return $this->setParameter('vads_trans_uuid');
    }

    public function setOwnerReference($value)
    {
        return $this->setParameter('ownerReference', $value);
    }

    public function getOwnerReference()
    {
        return $this->getParameter('ownerReference');
    }

    public function setMetadata(array $value)
    {
        return $this->setParameter('metadata', $value);
    }

    public function getMetadata()
    {
        return $this->getParameter('metadata');
    }

    public function formatCurrency($amount)
    {
        return (string) intval(strval($amount * 100));
    }

    public function addParameter($key, $value)
    {
        return $this->parameters->set($key, $value);
    }

    protected function generateSignature($data)
    {
        // Sort the data
        ksort($data);

        // Filter only the vads_* fields
        $matchedKeys = array_filter(array_keys($data), function ($v) {
            return strpos($v, 'vads_') == 0;
        });
        $data = array_intersect_key($data, array_flip($matchedKeys));

        // Add the certificate
        $data[] = $this->getCertificate();
        $signature_content = implode('+', $data);

        return base64_encode(hash_hmac('sha256',$signature_content, $this->getCertificate(), true));
    }
}
