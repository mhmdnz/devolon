<?php


namespace App\Services\Interfaces;


use App\Http\Requests\ProductCreateRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Offer;
use App\Models\Product;
use Illuminate\Support\Collection;

interface ProductServiceInterface extends MainServiceInterface
{
    public function getOffers(Product $product): Collection;

    public function isProductRelatedToOffer(Product $product, Offer $offer);
}
