<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;

class CategoryCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
			'name' => 'required|string|min:3|unique:categories',
			'parent_id' => 'numeric|required'
        ];
    }
}
