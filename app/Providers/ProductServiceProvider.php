<?php

namespace App\Providers;

use App\Services\Interfaces\ProductServiceInterface;
use App\Services\ProductServiceTrait;
use Illuminate\Support\ServiceProvider;

class ProductServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ProductServiceInterface::class, ProductServiceTrait::class);
    }
}
