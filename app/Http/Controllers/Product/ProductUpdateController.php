<?php

namespace App\Http\Controllers\Product;

use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\Interfaces\ProductServiceInterface;

class ProductUpdateController
{

    public function __construct(
        private ProductServiceInterface $productService,
        private ProductUpdateRequest $productRequest
    )
    {
    }

    public function __invoke(Product $product)
    {
        $this->productService->update($product, $this->productRequest->toArray());

        return ProductResource::make($product);
    }
}
