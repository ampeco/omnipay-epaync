<?php
namespace Omnipay\EpayNC\Message;

class RestNotificationResponse extends RestResponse
{

    public function isSuccessful()
    {
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
        return ($this->data['vads_card_brand']) ? $this->maskCard($this->data['vads_card_brand']) : null;
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

    /**
     * CB card is type VISA
     *
     */
    protected function maskCard(string $cardType): string
    {
        return ($cardType == 'CB') ? 'visa' : $cardType;
    }

}
