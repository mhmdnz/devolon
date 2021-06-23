<?php

namespace App\Http\Controllers\Offer;

use App\Http\Resources\ActionResource;
use App\Http\Resources\DeleteResultResource;
use App\Http\Resources\OfferCollection;
use App\Models\Offer;
use App\Models\Product;
use App\Services\Interfaces\OfferServiceInterface;

class OfferDeleteController
{

    public function __construct(private OfferServiceInterface $offerService)
    {
    }

    public function __invoke(Product $product, Offer $offer): DeleteResultResource
    {
        $deleteResult = $this->offerService->delete($offer);

        return DeleteResultResource::make($deleteResult);
    }
}
