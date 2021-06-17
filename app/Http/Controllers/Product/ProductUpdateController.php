<?php

namespace App\Http\Controllers\Product;

use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\Interfaces\ProductServiceInterface;

class ProductUpdateController
{

    /**
     * ProductUpdateController constructor.
     * @param ProductServiceInterface $productService
     * @param ProductUpdateRequest $productRequest
     */
    public function __construct(
        private ProductServiceInterface $productService,
        private ProductUpdateRequest $productRequest
    )
    {
    }

    /**
     * @param Product $product
     * @return ProductResource
     */
    public function __invoke(Product $product)
    {
        $this->productService->update($product, $this->productRequest->toArray());

        return ProductResource::make($product);
    }
}
