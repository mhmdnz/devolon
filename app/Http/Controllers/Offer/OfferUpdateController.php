<?php

namespace App\Http\Controllers\Offer;

use App\Http\Controllers\Controller;
use App\Http\Requests\OfferUpdateRequest;
use App\Http\Resources\OfferResource;
use App\Http\Resources\ProductResource;
use App\Models\Offer;
use App\Models\Product;
use App\Services\Interfaces\OfferServiceInterface;
use Illuminate\Http\Request;

class OfferUpdateController
{
    public function __construct(
        private OfferServiceInterface $offerService,
        private OfferUpdateRequest $offerUpdateRequest
    )
    {
    }

    public function __invoke(Product $product, Offer $offer)
    {
        $this->offerService->update($offer, $this->offerUpdateRequest->toArray());

        return OfferResource::make($offer);
    }
}
