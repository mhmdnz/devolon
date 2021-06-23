<?php


namespace App\Http\DTO;


class ProductOfferRelationErrorDTO implements ProductOfferRelationErrorDTOInterface
{
    public function __construct(public string $error)
    {
    }
}
