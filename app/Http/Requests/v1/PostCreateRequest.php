<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;

class PostCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
			'name' => 'required|string|min:3',
			'description' => 'string',
			'price' => 'required|numeric',
			'category_id' => 'required|numeric',
        ];
    }
}
