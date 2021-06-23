<?php


namespace App\Http\DTO;


class CheckoutBestOfferDTO implements CheckoutBestOfferDTOInterface
{
    public function __construct(
        public string $offerName,
        public int $quantity,
        public int $discountPercent,
        public int $price
    )
    {
    }
}
