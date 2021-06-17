<?php

namespace App\Services;

use App\Models\Offer;
use App\Models\Product;
use App\Repositories\Interfaces\MainRepositoryInterface;
use App\Repositories\Interfaces\OfferRepositoryInterface;
use App\Services\Interfaces\OfferServiceInterface;

class OfferService implements OfferServiceInterface
{
    use ServiceTrait;

    public function __construct(protected OfferRepositoryInterface $offerRepository)
    {
    }

    public function getModelRepository(): MainRepositoryInterface
    {
        return $this->offerRepository;
    }

    public function saveOnProduct(Product $product, array $offerItems): Offer
    {
        return $this->offerRepository->saveOnProduct($product, $offerItems);
    }
}
