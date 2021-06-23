<?php

namespace App\Http\Middleware;

use App\Http\DTO\ProductOfferRelationErrorDTO;
use App\Http\Resources\ProductOfferRelationErrorResource;
use App\Models\Offer;
use App\Models\Product;
use App\Services\Interfaces\OfferServiceInterface;
use App\Services\Interfaces\ProductServiceInterface;
use Closure;
use Illuminate\Http\Request;

class ProductOfferRelationCheckerMiddleware
{
    const PRODUCT_OFFER_RELATION_ERROR_MESSAGE = 'This offer is not related to the given product';

    public function __construct(
        private ProductServiceInterface $productService,
        private OfferServiceInterface $offerService
    )
    {
    }

    public function handle(Request $request, Closure $next)
    {
        $offer = $request->offer;
        $product = $request->product;
        if (!($offer instanceof Offer)) {
            $offer = $this->offerService->findOrFail($offer);
        }
        if (!($product instanceof Product)) {
            $product = $this->productService->findOrFail($product);
        }

        if ($this->productService->isProductRelatedToOffer($product, $offer)) {
            return $next($request);
        }
        $productOfferRelationErrorDTO = new ProductOfferRelationErrorDTO(self::PRODUCT_OFFER_RELATION_ERROR_MESSAGE);

        return ProductOfferRelationErrorResource::make($productOfferRelationErrorDTO);
    }
}
