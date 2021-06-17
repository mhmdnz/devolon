<?php


namespace App\Services\Interfaces;


use App\Models\Offer;
use App\Models\Product;

interface OfferServiceInterface extends MainServiceInterface
{
    public function saveOnProduct(Product $product, array $offerItems): Offer;
}
