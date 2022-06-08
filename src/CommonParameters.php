<?php
namespace Omnipay\EpayNC;

trait CommonParameters
{
    public function setUsername($value)
    {
        return $this->setParameter('username', $value);
    }

    public function getUsername()
    {
        return $this->getParameter('username');
    }

    public function setPassword($value)
    {
        return $this->setParameter('password', $value);
    }

    public function getPassword()
    {
        return $this->getParameter('password');
    }
}
