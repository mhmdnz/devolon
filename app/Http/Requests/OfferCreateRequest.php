<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OfferCreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:3|max:30',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:1'
        ];
    }
}
