<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Resources\DeleteResultResource;
use App\Models\Product;
use App\Services\Interfaces\ProductServiceInterface;

class ProductDeleteController
{

    public function __construct(private ProductServiceInterface $productService)
    {
    }

    public function __invoke(Product $product)
    {
        $deleteResult = $this->productService->delete($product);

        return DeleteResultResource::make($deleteResult);
    }
}
