<?php


namespace App\Services\Interfaces;


use App\Http\Requests\ProductCreateRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;
use Illuminate\Support\Collection;

interface ProductServiceInterface
{
    public function getOffers(Product $product): Collection;
}
