<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UpdateResultResource extends JsonResource
{
    const RESULT = [
        0 => 'Failed',
        1 => 'Success'
    ];

    public function toArray($request): array
    {
        return [
            'update_result' => self::RESULT[$this->result]
        ];
    }
}
