<?php


namespace App\Repositories\EloquentRepositories;


use App\Http\Requests\ProductCreateRequest;
use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;

class ProductEloquentRepository implements ProductRepositoryInterface
{

    public function save(array $productItems): Product
    {
        return Product::create($productItems);
    }

    public function update(Product $product, array $productItems): bool
    {
        return $product->update($productItems);
    }

    public function delete(Product $product): bool
    {
        return $product->delete();
    }

    public function insert(array $products): bool
    {
        return Product::insert($products);
    }
}
