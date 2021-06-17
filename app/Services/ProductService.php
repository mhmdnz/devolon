<?php


namespace App\Services;

use App\Models\Product;
use App\Repositories\Interfaces\MainRepositoryInterface;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Services\Interfaces\ProductServiceInterface;

class ProductService extends MainService implements ProductServiceInterface
{
    public function __construct(protected ProductRepositoryInterface $productRepository)
    {
    }

    public function setRepository(): MainRepositoryInterface
    {
        return $this->productRepository;
    }
}
