<?php

namespace App\Http\Controllers\API\v1;

use App\Events\NewSingleImageUploadedEvent;
use App\Http\Requests\v1\StoreUpdateRequest;
use App\Http\Requests\v1\UserCreateRequest;
use App\Http\Requests\v1\UserLoginRequest;
use App\Http\Requests\v1\UserUpdateRequest;
use App\Http\Resources\v1\StoresResource;
use App\User;
use App\Http\Controllers\Controller;
use App\Http\Resources\v1\UsersResource;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->only(['profile','update']);
    }

    public function profile(): UsersResource
    {
        $user = auth('api')->user();
        $this->authorize('canEditUser', $user);
        return new UsersResource($user);
    }

    public function update(UserUpdateRequest $request): UsersResource
	{
		$user = auth('api')->user();
		$user->update($request->only(['name','email','phone']));

		if($request->password){
			$user->update(['password' => Hash::make($request['password'])]);
		}
		if($request->image){
			$params = [
				'image' => $request->image,
				'object' => $user,
				'path' => 'images/users/',
			];
			event(new NewSingleImageUploadedEvent($params));
		}
		return new UsersResource($user);
	}

	public function updateStore(StoreUpdateRequest $request): StoresResource
	{
		$store = auth('api')->user()->store;
		$store->update($request->only(['name','description','email','phone','link']));
		if($request->image){
			$params = [
				'image' => $request->image,
				'object' => $store,
				'path' => 'images/stores/',
			];
			event(new NewSingleImageUploadedEvent($params));
		}
		return new StoresResource($store);
	}

    public function login(UserLoginRequest $request)
    {
        if(auth()->attempt(['email' => $request['email'], 'password' => $request['password']])){
            return response()->json([ 'data' => auth()->user()->passportToken ]);
        }
        return response()->json(['password' => trans('auth.failed')],422);
    }

    public function register(UserCreateRequest $request)
    {
        $request->merge([
            'password' => Hash::make($request['password']),
            'role' => $request['role'] ?: 'user'
        ]);
        $user = User::create($request->only(['name','email','password','phone','role']));
        if($request->image){
        	$params = [
				'image' => $request->image,
				'object' => $user,
				'path' => 'images/users/',
			];
        	event(new NewSingleImageUploadedEvent($params));
        }
        auth()->login($user);
        return response()->json([ 'data' => $user->passportToken ]);
    }

    public function logout()
    {
        auth()->logout();
        return response()->json(['success' => 'true']);
    }
}
