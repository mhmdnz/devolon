<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductCreateRequest;
use App\Http\Resources\ProductResource;
use App\Services\Interfaces\ProductServiceInterface;

class ProductCreateController extends Controller
{
    /**
     * ProductCreateController constructor.
     * @param ProductServiceInterface $productService
     */
    public function __construct(
        private ProductServiceInterface $productService,
        private ProductCreateRequest $productRequest
    )
    {
    }
    

    /**
     * @return ProductResource
     */
    public function __invoke()
    {
        return ProductResource::make($this->productService->save($this->productRequest->toArray()));
    }
}
