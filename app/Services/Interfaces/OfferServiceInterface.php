<?php


namespace App\Services\Interfaces;


use App\Http\DTO\BooleanResponseDTOInterface;
use App\Http\DTO\DeleteResultDTOInterface;
use App\Models\Offer;
use App\Models\Product;

interface OfferServiceInterface extends MainServiceInterface
{
    public function saveOnProduct(Product $product, array $offerItems): Offer;
}
