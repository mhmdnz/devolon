<?php

namespace App\Repositories\EloquentRepositories;

use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class ProductEloquentTrait implements ProductRepositoryInterface
{
    use MainEloquentTrait;

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
}
