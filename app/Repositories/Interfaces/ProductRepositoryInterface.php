<?php


namespace App\Repositories\Interfaces;


use App\Http\Requests\ProductCreateRequest;
use App\Models\Product;
use Illuminate\Support\Collection;

interface ProductRepositoryInterface extends MainRepositoryInterface
{
    public function getOffers(Product $product): Collection;

    public function getOffersByQuantityLimit(Product $product, int $limit): Collection;
}
