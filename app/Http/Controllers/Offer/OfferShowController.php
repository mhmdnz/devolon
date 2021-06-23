<?php

namespace App\Http\Controllers\Offer;

use App\Http\Resources\OfferCollection;
use App\Models\Offer;
use App\Models\Product;
use App\Services\Interfaces\ProductServiceInterface;

class OfferShowController
{

    public function __construct(private ProductServiceInterface $productService)
    {
    }

    public function __invoke(Product $product, Offer $offer = null): OfferCollection
    {
        $offers = $this->productService->getOffers($product, $offer);

        return OfferCollection::make($offers);
    }
}
