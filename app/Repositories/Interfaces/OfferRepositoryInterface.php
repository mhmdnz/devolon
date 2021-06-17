<?php


namespace App\Repositories\Interfaces;


use App\Models\Offer;
use App\Models\Product;

interface OfferRepositoryInterface
{
    public function saveOnProduct(Product $product, array $offerItems): Offer;
}
