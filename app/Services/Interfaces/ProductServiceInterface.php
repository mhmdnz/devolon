<?php


namespace App\Services\Interfaces;


use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;

interface ProductServiceInterface
{
    public function save(array $productRequest): Product;

    public function update(Product $product, array $productItems): bool;

    public function delete(Product $product): bool;
}
