<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UpdateResultResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'update_result' => $this->getResult()
        ];
    }
}
