<?php

namespace App\Services\Interfaces;

use App\Http\DTO\CheckoutDTOInterface;

interface CheckoutServiceInterface
{
    public function calculateCheckout(array $productIds): CheckoutDTOInterface;
}
