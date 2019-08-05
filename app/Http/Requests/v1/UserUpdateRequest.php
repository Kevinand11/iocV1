<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
    	if($this->route()->parameter('user')){
    		return $this->user('api')->can('canEditUser',$this->route()->parameter('user'));
		}
        return true;
    }

    public function rules(): array
    {
    	$user = $this->route()->parameter('user') ?: $this->user('api');
        return [
			'name' => 'required|string|min:3',
			'email' => 'required|email|unique:users,email,'.$user->id,
			'password' => 'sometimes|nullable|min:6|confirmed',
			'phone.phone' => 'required|phone',
			'phone.phone_country' => 'required_with:phone.phone',
			'image' => 'sometimes|nullable|string',
			'role' => 'sometimes|nullable|string'
        ];
    }
}
