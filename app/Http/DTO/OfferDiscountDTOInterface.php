<?php


namespace App\Http\DTO;


interface OfferDiscountDTOInterface
{
    public function setOfferId($id): void;

    public function setOfferName($name): void;

    public function setQuantity($quantity): void;

    public function setDiscountPercent($discountPercent): void;

    public function setPrice($price): void;

    public function jsonSerialize(): array;
}
