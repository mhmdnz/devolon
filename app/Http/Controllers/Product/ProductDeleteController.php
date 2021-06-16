<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\Interfaces\ProductServiceInterface;

class ProductDeleteController extends Controller
{
    /**
     * ProductCreateController constructor.
     * @param ProductServiceInterface $productService
     */
    public function __construct(
        private ProductServiceInterface $productService
    )
    {
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Product $product)
    {
        return response()->json($this->productService->delete($product));
    }
}
