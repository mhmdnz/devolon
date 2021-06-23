<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DeleteResultResource extends JsonResource
{
    const RESULT = [
        0 => 'Failed',
        1 => 'Success'
    ];

    public function toArray($request)
    {
        return [
            'delete_result' => self::RESULT[$this->result]
        ];
    }
}
