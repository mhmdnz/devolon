<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductCreateRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;
use App\Services\Interfaces\ProductServiceInterface;
use Illuminate\Http\Request;

class ProductUpdateController extends Controller
{
    /**
     * ProductCreateController constructor.
     * @param ProductServiceInterface $productService
     */
    public function __construct(
        private ProductServiceInterface $productService,
        private ProductUpdateRequest $productRequest
    )
    {
    }
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Product $product)
    {
        return response()->json([
            'result' => $this->productService->update($product, $this->productRequest->toArray())
        ]);
    }
}
