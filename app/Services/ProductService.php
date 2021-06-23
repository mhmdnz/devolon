<?php

namespace App\Services;

use App\Models\Offer;
use App\Models\Product;
use App\Repositories\Interfaces\MainRepositoryInterface;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Services\Interfaces\ProductServiceInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class ProductService implements ProductServiceInterface
{
    use ServiceTrait;

    public function __construct(protected ProductRepositoryInterface $productRepository)
    {
    }

    public function getModelRepository(): MainRepositoryInterface
    {
        return $this->productRepository;
    }

    public function getOffers(Product $product, Offer $offer = null): Collection
    {
        $result = collect()->add($offer);
        if (!$offer) {
            $result = $this->productRepository->getOffers($product);
        }

        return $result;
    }

    public function isProductRelatedToOffer(Product $product, Offer $offer)
    {
        return $offer->product->id == $product->id;
    }

    public function getProducts(Product $product = null): Collection
    {
        $result = collect()->add($product);
        if (!$product) {
            $result = $this->productRepository->all();
        }

        return $result;
    }
}
