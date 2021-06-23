<?php

namespace App\Http\Controllers\Offer;

use App\Http\Requests\OfferUpdateRequest;
use App\Http\Resources\OfferResource;
use App\Models\Offer;
use App\Models\Product;
use App\Services\Interfaces\OfferServiceInterface;

class OfferUpdateController
{
    public function __construct(
        private OfferServiceInterface $offerService,
        private OfferUpdateRequest $offerUpdateRequest
    )
    {
    }

    public function __invoke(Product $product, Offer $offer): OfferResource
    {
        $this->offerService->update($offer, $this->offerUpdateRequest->toArray());

        return OfferResource::make($offer);
    }
}
