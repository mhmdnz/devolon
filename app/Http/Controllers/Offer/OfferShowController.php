<?php

namespace App\Http\Controllers\Offer;

use App\Http\Controllers\Controller;
use App\Http\Requests\OfferCreateRequest;
use App\Models\Product;
use App\Services\Interfaces\OfferServiceInterface;
use App\Services\Interfaces\ProductServiceInterface;
use Illuminate\Http\Request;

class OfferShowController extends Controller
{
    /**
     * OfferShowController constructor.
     * @param ProductServiceInterface $productService
     */
    public function __construct(
        protected ProductServiceInterface $productService
    )
    {
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Product $product)
    {
        return response()->json($this->productService->getOffers($product));
    }
}
