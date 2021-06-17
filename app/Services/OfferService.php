<?php


namespace App\Services;


use App\Models\Offer;
use App\Models\Product;
use App\Repositories\Interfaces\MainRepositoryInterface;
use App\Repositories\Interfaces\OfferRepositoryInterface;
use App\Services\Interfaces\OfferServiceInterface;
use Illuminate\Database\Eloquent\Model;

class OfferService implements OfferServiceInterface
{
    use MainServiceTrait;

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
