<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DeleteResultResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'delete_result' => $this->getResult()
        ];
    }
}
