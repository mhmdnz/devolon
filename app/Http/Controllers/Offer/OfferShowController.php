<?php

namespace App\Http\Controllers\Offer;

use App\Http\Resources\OfferCollection;
use App\Models\Product;
use App\Services\Interfaces\ProductServiceInterface;

class OfferShowController
{
    /**
     * OfferShowController constructor.
     * @param ProductServiceInterface $productService
     */
    public function __construct(
        protected ProductServiceInterface $productService
    )
    {
    }

    /**
     * @param Product $product
     * @return OfferCollection
     */
    public function __invoke(Product $product)
    {
        return OfferCollection::make($this->productService->getOffers($product));
    }
}
