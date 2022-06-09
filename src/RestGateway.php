<?php

namespace Omnipay\EpayNC;

use Omnipay\Common\AbstractGateway;
use Omnipay\Common\Message\RequestInterface;
use Omnipay\EpayNC\Message\NotificationRequest;
use Omnipay\EpayNC\Message\RestCreateCardRequest;
use Omnipay\EpayNC\Message\RestNotificationResponse;
use Omnipay\EpayNC\Message\RestPurchaseRequest;
use Omnipay\EpayNC\Message\RestResponse;

/**
 * EpayNC Rest RestGateway
 *
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class RestGateway extends AbstractGateway
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'EpayNC Rest';
    }

    /**
     * @return array
     */
    public function getDefaultParameters()
    {
        return [
            'username' => '',
            'password' => '',
            'testPassword' => '',
            'testMode' => true,
        ];
    }

    /**
     * @param array $parameters
     * @return RequestInterface
     */
    public function purchase(array $parameters = [])
    {
        return $this->createRequest(RestPurchaseRequest::class, $parameters);
    }

    public function createCard(array $parameters = []): RequestInterface
    {
        return $this->createRequest(RestCreateCardRequest::class, $parameters);
    }

    /**
     * @param string
     * @return self
     */
    public function setUsername($value)
    {
        return $this->setParameter('username', $value);
    }

    /**
     * @return self
     */
    public function getUsername()
    {
        return $this->getParameter('username');
    }

    /**
     * @param string
     * @return self
     */
    public function setPassword($value)
    {
        return $this->setParameter('password', $value);
    }

    /**
     * @return string
     * @return self
     */
    public function getPassword()
    {
        return $this->getParameter('password');
    }

    /**
     * @param string
     */
    public function setTestPassword($value)
    {
        return $this->setParameter('testPassword', $value);
    }

    /**
     * @return string
     */
    public function getTestPassword()
    {
        return $this->getParameter('testPassword');
    }

    public function acceptNotification(array $requestData): RestNotificationResponse
    {
        return new RestNotificationResponse(
            $this->createRequest(NotificationRequest::class, $requestData),
            array_merge($requestData, [
                'isSuccessful' => true,
            ]), 200
        );
    }
}
