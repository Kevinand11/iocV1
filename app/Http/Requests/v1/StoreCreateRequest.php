<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;

class StoreCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
			'name' => 'required|string|min:3',
			'description' => 'sometimes|string',
			'email' => 'required|email|unique:stores',
			'phone.phone' => 'required|phone',
			'phone.phone_country' => 'required_with:phone.phone',
			'link' => 'sometimes|url',
			'image' => 'sometimes|nullable|string'
        ];
    }
}
