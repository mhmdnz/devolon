<?php

namespace App\Providers;

use App\Repositories\EloquentRepositories\OfferEloquentRepository;
use App\Repositories\Interfaces\OfferRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class OfferRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(OfferRepositoryInterface::class, OfferEloquentRepository::class);
    }
}
