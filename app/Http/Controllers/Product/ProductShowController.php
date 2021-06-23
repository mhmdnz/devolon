<?php

namespace App\Http\Controllers\Product;

use App\Http\Resources\ProductCollection;
use App\Models\Product;
use App\Services\Interfaces\ProductServiceInterface;

class ProductShowController
{
    public function __construct(private ProductServiceInterface $productService)
    {
    }

    public function __invoke(Product $product = null) : ProductCollection
    {
        $product = $this->productService->getProducts($product);

        return ProductCollection::make($product);
    }
}
