<?php

namespace App\Http\DTO;

use Ramsey\Uuid\Type\Decimal;

class CheckoutDTO implements CheckoutDTOInterface, \JsonSerializable
{
    public $price;
    public $discount;
    public $offers;
    public $priceWithoutDiscount;

    public function setPrice($price): void
    {
        $this->price = $price;
    }

    public function setDiscount($discount): void
    {
        $this->discount = $discount;
    }

    public function setOffers($offers): void
    {
        $this->offers = $offers;
    }

    public function setPriceWithoutDiscount($price): void
    {
        $this->priceWithoutDiscount = $price;
    }

    public function jsonSerialize(): array
    {
        return [
            'price_with_discount' => $this->price,
            'price_without_discount' => $this->priceWithoutDiscount,
            'discount' => $this->discount,
            'discount_calculation' => $this->offers
        ];
    }
}
