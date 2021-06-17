<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\Interfaces\ProductServiceInterface;

class ProductDeleteController
{

    /**
     * ProductCreateController constructor.
     * @param ProductServiceInterface $productService
     */
    public function __construct(private ProductServiceInterface $productService)
    {
    }

    /**
     * @param Product $product
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Product $product)
    {
        $this->productService->delete($product);

        return response()->noContent();
    }
}
