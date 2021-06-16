<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Services\Interfaces\ProductServiceInterface;

class ProductCreateController extends Controller
{
    /**
     * ProductCreateController constructor.
     * @param ProductServiceInterface $productService
     */
    public function __construct(
        private ProductServiceInterface $productService,
        private ProductRequest $productRequest
    )
    {
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke()
    {
        return response()->json($this->productService->save($this->productRequest));
    }
}
