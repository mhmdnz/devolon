<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductShowController extends Controller
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
