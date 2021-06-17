<?php

namespace App\Providers;

use App\Services\Interfaces\OfferServiceInterface;
use App\Services\OfferService;
use Illuminate\Support\ServiceProvider;

class OfferServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(OfferServiceInterface::class, OfferService::class);
    }
}
