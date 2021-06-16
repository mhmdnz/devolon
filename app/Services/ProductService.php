<?php


namespace App\Services;


use App\Http\Requests\ProductCreateRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Services\Interfaces\ProductServiceInterface;

class ProductService implements ProductServiceInterface
{
    public function __construct(protected ProductRepositoryInterface $productRepository)
    {
    }

    public function save(array $productRequest): Product
    {
        return $this->productRepository->save($productRequest);
    }

    public function update(Product $product, array $productItems): bool
    {
        return $this->productRepository->update($product, $productItems);
    }

    public function delete(Product $product): bool
    {
        return $this->productRepository->delete($product);
    }

    public function insert(array $products): bool
    {
        return $this->productRepository->insert($products);
    }
}
