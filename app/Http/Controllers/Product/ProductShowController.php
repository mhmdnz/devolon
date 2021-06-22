<?php

namespace App\Http\Controllers\Product;

use App\Http\Resources\ProductResource;
use App\Models\Product;

class ProductShowController
{

    public function __invoke(Product $product)
    {
        return ProductResource::make($product);
    }
}
