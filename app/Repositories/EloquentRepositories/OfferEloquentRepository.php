<?php


namespace App\Repositories\EloquentRepositories;

use App\Models\Offer;
use App\Models\Product;
use App\Repositories\Interfaces\OfferRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class OfferEloquentRepository implements OfferRepositoryInterface
{
    use EloquentRepositoryTrait;

    public function __construct(protected Offer $offer)
    {
    }

    public function getModel(): Model
    {
        return $this->offer;
    }

    public function saveOnProduct(Product $product, array $offerItems): Offer
    {
        $offer = $this->offer::make($offerItems);
        $product->offers()->save($offer);

        return $offer;
    }

    public function getProduct(Offer $offer): Product
    {
        return $offer->product;
    }
}
