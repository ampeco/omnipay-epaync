<?php

namespace Omnipay\EpayNC\Message;

use Omnipay\Common\Message\ResponseInterface;

class NotificationRequest extends AbstractRequest
{

    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return mixed
     */
    public function getData()
    {
        return [];
    }

    /**
     * Send the request with specified data
     *
     * @param mixed $data The data to send
     * @return ResponseInterface
     */
    public function sendData($data)
    {
        return $this->createResponse($data);
    }
}
