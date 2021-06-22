<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductInsertRequest extends FormRequest
{

    public function rules()
    {
        return [
            '*.name' => 'required|min:3|max:30',
            '*.unit_price' => 'required|numeric|min:1'
        ];
    }
}
