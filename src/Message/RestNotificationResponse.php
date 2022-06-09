<?php
namespace Omnipay\EpayNC\Message;

class RestNotificationResponse extends RestResponse
{

    public function isSuccessful()
    {
        \Illuminate\Support\Facades\Log::info('we are isSuccessful' . $this->statusCode, $this->data);
        return $this->statusCode < 400 && @$this->data['vads_identifier_status'] === 'CREATED';
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
