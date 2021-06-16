<?php


namespace App\Services;


use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Services\Interfaces\ProductServiceInterface;

class ProductService implements ProductServiceInterface
{
    public function __construct(protected ProductRepositoryInterface $productRepository)
    {
    }

    public function save(ProductRequest $productRequest): Product
    {
        return $this->productRepository->save($productRequest->toArray());
    }

    public function update(Product $product, array $productItems): bool
    {
        return $this->productRepository->update($product, $productItems);
    }

    public function delete(Product $product): bool
    {
        return $this->productRepository->delete($product);
    }
}
