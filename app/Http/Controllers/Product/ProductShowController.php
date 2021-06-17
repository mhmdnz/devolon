<?php

namespace App\Http\Controllers\Product;

use App\Http\Resources\ProductResource;
use App\Models\Product;

class ProductShowController
{

    /**
     * @param Product $product
     * @return ProductResource
     */
    public function __invoke(Product $product)
    {
        return ProductResource::make($product);
    }
}
