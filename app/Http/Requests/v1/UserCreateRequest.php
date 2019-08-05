<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
			'name' => 'required|string|min:3',
			'email' => 'required|email|unique:users',
			'phone.phone' => 'required|phone',
			'phone.phone_country' => 'required_with:phone.phone',
			'password' => 'required|min:6|string|confirmed',
			'image' => 'sometimes|nullable|string',
			'role' => 'sometimes|nullable|string'
        ];
    }
}
