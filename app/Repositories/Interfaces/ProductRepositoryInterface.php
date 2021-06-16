<?php


namespace App\Repositories\Interfaces;


use App\Http\Requests\CreateProductRequest;
use App\Models\Product;

interface ProductRepositoryInterface
{
    public function save(array $productItems): Product;

    public function update(Product $product, array $productItems): bool;

    public function delete(Product $product): bool;
}
