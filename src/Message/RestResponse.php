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

    public function isForTokenization(): bool
    {
        return isset($this->data['vads_page_action']) && $this->data['vads_page_action'] === 'REGISTER';
    }

    public function getToken(): ?string
    {
        return @$this->data['vads_identifier']; // the tokenized card
    }

    public function getCardNumber(): ?string
    {
        return @$this->data['vads_card_number'];
    }

    public function getCardBrand(): ?string
    {
        return @$this->data['vads_card_brand'];
    }

    public function getExpirationMonth(): ?string
    {
        return @$this->data['vads_expiry_month'];
    }

    public function getExpirationYear(): ?string
    {
        return @$this->data['vads_expiry_year'];
    }

    public function getTransactionReference(): ?string
    {
        return @$this->data['vads_trans_id'];
    }
}
