<?php

namespace App\Providers;

use App\Services\CheckoutService;
use App\Services\Interfaces\CheckoutServiceInterface;
use Illuminate\Support\ServiceProvider;

class CheckoutServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CheckoutServiceInterface::class, CheckoutService::class);
    }
}
