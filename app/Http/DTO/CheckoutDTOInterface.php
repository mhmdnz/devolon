<?php


namespace App\Http\DTO;


use Ramsey\Uuid\Type\Decimal;

interface CheckoutDTOInterface
{
    public function setPrice($price): void;

    public function setDiscount($discount): void;

    public function setOffers($offers): void;

    public function setPriceWithoutDiscount($price): void;

    public function jsonSerialize(): array;
}
