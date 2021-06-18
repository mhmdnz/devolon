<?php

namespace App\Providers;

use App\Http\DTO\CheckoutDTO;
use App\Http\DTO\CheckoutDTOInterface;
use Illuminate\Support\ServiceProvider;

class CheckoutDTOProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CheckoutDTOInterface::class, CheckoutDTO::class);
    }
}
