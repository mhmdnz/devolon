<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{

    public function rules()
    {
        return [
            '*.id' => 'required|exists:products,id'
        ];
    }
}
