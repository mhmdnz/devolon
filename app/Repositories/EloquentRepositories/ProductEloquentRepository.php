<?php

namespace App\Repositories\EloquentRepositories;

use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class ProductEloquentRepository implements ProductRepositoryInterface
{
    use EloquentRepositoryTrait;

    public function __construct(protected Product $product)
    {
    }

    public function getModel(): Model
    {
        return $this->product;
    }

    public function getOffers(Product $product): Collection
    {
        return $product->offers;
    }


    public function getOffersByQuantityLimit(Product $product, int $limit): Collection
    {
        return $product->offers()->where('quantity', '<=', $limit)->get();
    }
}
