<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CheckoutResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'price_with_discount' => $this->price,
            'price_without_discount' => $this->priceWithoutDiscount,
            'discount' => $this->discount,
            'discount_calculation' => $this->offers
        ];
    }
}
