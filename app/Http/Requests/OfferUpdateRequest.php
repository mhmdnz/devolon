<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OfferUpdateRequest extends FormRequest
{

    public function rules()
    {
        return [
            'name' => 'min:3|max:30',
            'quantity' => 'integer|min:1',
            'price' => 'numeric|min:1'
        ];
    }
}
