<?php


namespace App\Http\DTO;


class CheckoutBestOfferDTO implements CheckoutBestOfferDTOInterface,\JsonSerializable
{
    public $offerName;
    public $quantity;
    public $discountPercent;
    public $price;

    public function setOfferName($name): void
    {
        $this->offerName = $name;
    }

    public function setQuantity($quantity): void
    {
        $this->quantity = $quantity;
    }

    public function setDiscountPercent($discountPercent): void
    {
        $this->discountPercent = $discountPercent;
    }

    public function setPrice($price): void
    {
        $this->price = $price;
    }

    public function jsonSerialize(): array
    {
        return [
            'offerName' => $this->offerName,
            'price' => $this->price,
            'discountPercent' => $this->discountPercent,
            'quantity' => $this->quantity
        ];
    }
}
