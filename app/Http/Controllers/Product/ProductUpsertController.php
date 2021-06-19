<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductInsertRequest;
use App\Services\Interfaces\ProductServiceInterface;

class ProductUpsertController
{

    /**
     * ProductUpsertController constructor.
     * @param ProductServiceInterface $productService
     * @param ProductInsertRequest $productRequest
     */
    public function __construct(
        private ProductServiceInterface $productService,
        private ProductInsertRequest $productRequest
    )
    {
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke()
    {
        return response()->json($this->productService->upsert($this->productRequest->toArray()));
    }
}
