<?php

namespace App\Http\Controllers\Product;

use App\Http\Requests\ProductCreateRequest;
use App\Http\Resources\ProductResource;
use App\Services\Interfaces\ProductServiceInterface;

class ProductCreateController
{

    public function __construct(
        private ProductServiceInterface $productService,
        private ProductCreateRequest $productRequest
    )
    {
    }

    public function __invoke()
    {
        $product = $this->productService->save($this->productRequest->validated());

        return ProductResource::make($product);
    }
}
