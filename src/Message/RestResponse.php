<?php
namespace Omnipay\EpayNC\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;

class RestResponse extends AbstractResponse
{
    /**
     * @var integer
     */
    protected $statusCode;

    /**
     * @param RequestInterface $request
     * @param array $data
     * @param integer $statusCode
     */
    public function __construct(RequestInterface $request, array $data, $statusCode)
    {
        parent::__construct($request, $data);
        $this->statusCode = $statusCode;
    }

    /**
     * @return boolean
     */
    public function isSuccessful()
    {
        return !empty($this->data['status']) && $this->data['status'] == 'SUCCESS' && $this->getCode() < 400;
    }

    /**
     * @return integer
     */
    public function getCode()
    {
        return $this->statusCode;
    }
}
