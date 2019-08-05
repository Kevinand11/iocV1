<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
		if($this->route()->parameter('store')){
			return $this->user('api')->can('canEditStore',$this->route()->parameter('store'));
		}
		return true;
    }

    public function rules(): array
    {
		$store = $this->route()->parameter('store') ?: $this->user('api')->store;
        return [
			'name' => 'required|string|min:3',
			'description' => 'sometimes|string',
			'email' => 'required|email|unique:stores,email,' .$store->id,
			'phone.phone' => 'required|phone',
			'phone.phone_country' => 'required_with:phone.phone',
			'link' => 'sometimes|url',
			'image' => 'sometimes|nullable|string'
        ];
    }
}
