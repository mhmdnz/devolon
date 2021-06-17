<?php

namespace App\Http\Controllers\Offer;

use App\Http\Resources\ActionResource;
use App\Http\Resources\OfferCollection;
use App\Models\Offer;
use App\Models\Product;
use App\Services\Interfaces\OfferServiceInterface;

class OfferDeleteController
{

    /**
     * OfferDeleteController constructor.
     * @param OfferServiceInterface $offerService
     */
    public function __construct(private OfferServiceInterface $offerService)
    {
    }

    /**
     * @param Product $product
     * @param Offer $offer
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Product $product, Offer $offer)
    {
        $this->offerService->deleteFromProduct($product, $offer);

        return response()->noContent();
    }
}
