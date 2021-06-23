<?php

namespace App\Http\Controllers\Checkout;

use App\Http\Requests\CheckoutRequest;
use App\Http\Resources\CheckoutResource;
use App\Services\Interfaces\CheckoutServiceInterface;

class CheckoutCalculateController
{

    public function __construct(
        private CheckoutServiceInterface $checkoutService,
        private CheckoutRequest $checkoutRequest
    )
    {
    }

    public function __invoke(): CheckoutResource
    {
        $calculateCheckout = $this->checkoutService->calculateCheckout($this->checkoutRequest->validated());

        return CheckoutResource::make($calculateCheckout);
    }
}
