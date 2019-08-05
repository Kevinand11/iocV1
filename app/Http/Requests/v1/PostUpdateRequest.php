<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;

class PostUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user('api')->can('canEditPost',$this->route()->parameter('post'));
    }

    public function rules(): array
    {
        return [
			'name' => 'required|string|min:3',
			'description' => 'string',
			'category_id' => 'required|numeric',
			'price' => 'required|numeric'
        ];
    }
}
