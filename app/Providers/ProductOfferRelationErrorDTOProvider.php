<?php

namespace App\Providers;

use App\Http\DTO\ProductOfferRelationErrorDTO;
use App\Http\DTO\ProductOfferRelationErrorDTOInterface;
use Illuminate\Support\ServiceProvider;

class ProductOfferRelationErrorDTOProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(ProductOfferRelationErrorDTOInterface::class, ProductOfferRelationErrorDTO::class);
    }
}
