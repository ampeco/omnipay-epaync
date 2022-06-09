<?php
namespace Omnipay\EpayNC\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;

class RestResponse extends AbstractResponse
{
    /**
     * @var int
     */
    protected $statusCode;

    /**
     * @param RequestInterface $request
     * @param array $data
     * @param int $statusCode
     */
    public function __construct(RequestInterface $request, array $data, int $statusCode)
    {
        parent::__construct($request, $data);
        $this->statusCode = $statusCode;
    }

    /**
     * @return boolean
     */
    public function isSuccessful()
    {
        return $this->statusCode < 400 && $this->data['isSuccessful'];
    }

    /**
     * @return integer
     */
    public function getCode()
    {
        return $this->statusCode;
    }
}
