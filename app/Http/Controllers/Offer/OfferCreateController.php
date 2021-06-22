<?php

namespace App\Http\Controllers\Offer;

use App\Http\Requests\OfferCreateRequest;
use App\Http\Resources\OfferResource;
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
     * @param Product $product
     * @return OfferResource
     */
    public function __invoke(Product $product)
    {
        $offer = $this->offerService->saveOnProduct($product, $this->offerCreateRequest->validated());

        return OfferResource::make($offer);
    }
}
