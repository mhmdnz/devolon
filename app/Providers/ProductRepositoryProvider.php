<?php

namespace App\Providers;

use App\Repositories\EloquentRepositories\ProductEloquentTrait;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class ProductRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ProductRepositoryInterface::class, ProductEloquentTrait::class);
    }
}
