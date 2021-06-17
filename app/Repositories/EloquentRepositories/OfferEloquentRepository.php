<?php


namespace App\Repositories\EloquentRepositories;

use App\Models\Offer;
use App\Repositories\Interfaces\OfferRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class OfferEloquentRepository extends MainEloquentRepository implements OfferRepositoryInterface
{
    public function __construct(protected Offer $offer)
    {
    }

    public function setModel(): Model
    {
         return $this->offer;
    }
}
