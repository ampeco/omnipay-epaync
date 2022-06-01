<?php
namespace Omnipay\EpayNC;

use Omnipay\Common\AbstractGateway;

/**
 * EpayNC Gateway
 *
 * @author Aurélien Schelcher <a.schelcher@ubitransports.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class Gateway extends AbstractGateway
{
    public function getName()
    {
        return 'EpayNC';
    }

    public function getDefaultParameters()
    {
        return array(
            'certificate' => '',
            'testMode' => false,
        );
    }

    public function getCertificate()
    {
        return $this->getParameter('certificate');
    }

    public function setCertificate($value)
    {
        return $this->setParameter('certificate', $value);
    }

    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\EpayNC\Message\PurchaseRequest', $parameters);
    }

    public function completePurchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\EpayNC\Message\CompletePurchaseRequest', $parameters);
    }

    public function createCard(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\EpayNC\Message\CreateCardRequest', $parameters);
    }

    public function completeCardCreation(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\EpayNC\Message\CompleteCardCreationRequest', $parameters);
    }
}
