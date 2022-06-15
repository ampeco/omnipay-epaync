<?php

namespace Omnipay\EpayNC;

use Omnipay\Common\AbstractGateway;
use Omnipay\Common\Message\RequestInterface;
use Omnipay\EpayNC\Message\NotificationRequest;
use Omnipay\EpayNC\Message\RestCreateCardRequest;
use Omnipay\EpayNC\Message\RestDeleteCardRequest;
use Omnipay\EpayNC\Message\RestNotificationResponse;
use Omnipay\EpayNC\Message\RestPurchaseRequest;

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

    public function deleteCard(array $parameters = [])
    {
        return $this->createRequest(RestDeleteCardRequest::class, $parameters);
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
        if (isset($requestData['vads_identifier_status']) && $requestData['vads_identifier_status'] == 'CREATED') {
            $isSuccessfull = true;
            $notificationStatusCode = 200;
        } else {
            $isSuccessfull = false;
            $notificationStatusCode = 400;
        }

        return new RestNotificationResponse(
            $this->createRequest(NotificationRequest::class, $requestData),
            array_merge($requestData, [
                'isSuccessful' => $isSuccessfull,
            ]), $notificationStatusCode
        );
    }

    public function authorize(array $parameters = [])
    {
        throw new \RuntimeException('The pre-authorize is not supported by EpayNC bank');
    }

    public function supportsAuthorize(): bool
    {
        return false;
    }

    public function capture(array $parameters = [])
    {
        throw new \RuntimeException('The capture method is not supported by EpayNC bank');
    }

    public function supportsCapture()
    {
        return false;
    }
}
