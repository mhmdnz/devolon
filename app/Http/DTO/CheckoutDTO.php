<?php

namespace App\Http\DTO;


class CheckoutDTO implements CheckoutDTOInterface
{

    public function __construct(
        public int $price,
        public int $discount,
        public array $offers,
        public int $priceWithoutDiscount
    )
    {
    }
}
