<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductOfferRelationErrorResource extends JsonResource
{

    public function toArray($request): array
    {
        return [
            'error_message' => $this->error
        ];
    }
}
