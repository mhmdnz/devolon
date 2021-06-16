<?php


namespace App\Services\Interfaces;


use App\Http\Requests\ProductCreateRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;

interface ProductServiceInterface
{
    public function save(array $productRequest): Product;

    public function insert(array $products): bool;

    public function update(Product $product, array $productItems): bool;

    public function delete(Product $product): bool;
}
