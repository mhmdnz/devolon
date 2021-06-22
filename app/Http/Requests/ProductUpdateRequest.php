<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
{

    public function rules()
    {
        return [
            'name' => 'min:3|max:30',
            'unit_price' => 'numeric|min:1'
        ];
    }
}
