<?php

namespace App\Http\Controllers\Offer;

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
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Product $product)
    {
        return response()->json($this->productService->getOffers($product));
    }
}
