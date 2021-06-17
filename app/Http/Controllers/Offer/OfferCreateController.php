<?php

namespace App\Http\Controllers\Offer;

use App\Http\Requests\OfferCreateRequest;
use App\Models\Product;
use App\Services\Interfaces\OfferServiceInterface;

class OfferCreateController
{
    /**
     * OfferCreateController constructor.
     * @param OfferServiceInterface $offerService
     * @param OfferCreateRequest $offerCreateRequest
     */
    public function __construct(
        private OfferServiceInterface $offerService,
        private OfferCreateRequest $offerCreateRequest
    )
    {
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Product $product)
    {
        return response()->json($this->offerService->saveOnProduct($product, $this->offerCreateRequest->validated()));
    }
}
