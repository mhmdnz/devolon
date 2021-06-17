<?php


namespace App\Repositories\Interfaces;


use App\Http\Requests\ProductCreateRequest;
use App\Models\Product;
use Illuminate\Support\Collection;

interface ProductRepositoryInterface
{
    public function getOffers(Product $product): Collection;
}
