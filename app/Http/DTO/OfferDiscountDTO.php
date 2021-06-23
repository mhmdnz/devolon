<?php


namespace App\Http\DTO;


class OfferDiscountDTO implements OfferDiscountDTOInterface
{

    public function __construct(
        public int $id,
        public string $offerName,
        public int $quantity,
        public int $discountPercent,
        public int $price
    )
    {
    }

    public function setOfferId($id): void
    {
        $this->id = $id;
    }
}
