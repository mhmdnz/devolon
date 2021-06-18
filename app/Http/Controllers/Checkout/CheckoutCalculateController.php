<?php

namespace App\Http\Controllers\Checkout;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckoutRequest;
use App\Services\Interfaces\CheckoutServiceInterface;
use Illuminate\Http\Request;

class CheckoutCalculateController
{
    /**
     * CheckoutCalculateController constructor.
     * @param CheckoutServiceInterface $checkoutService
     * @param CheckoutRequest $checkoutRequest
     */
    public function __construct(
        private CheckoutServiceInterface $checkoutService,
        private CheckoutRequest $checkoutRequest
    )
    {
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke()
    {
        return response()->json(
            $this->checkoutService->calculateCheckout($this->checkoutRequest->validated())
        );
    }
}
