<?php


namespace App\Services\Interfaces;


use App\Http\Requests\ProductRequest;
use App\Models\Product;

interface ProductServiceInterface
{
    public function save(ProductRequest $productRequest): Product;

    public function update(Product $product, array $productItems): bool;

    public function delete(Product $product): bool;
}
