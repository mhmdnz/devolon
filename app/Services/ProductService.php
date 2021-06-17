<?php

namespace App\Services;

use App\Models\Product;
use App\Repositories\Interfaces\MainRepositoryInterface;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Services\Interfaces\ProductServiceInterface;
use Illuminate\Support\Collection;

class ProductService implements ProductServiceInterface
{
    use ServiceTrait;

    public function __construct(protected ProductRepositoryInterface $productRepository)
    {
    }

    public function getModelRepository(): MainRepositoryInterface
    {
        return $this->productRepository;
    }

    public function getOffers(Product $product): Collection
    {
        return $this->productRepository->getOffers($product);
    }
}
