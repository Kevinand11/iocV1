<?php

namespace App\Http\Controllers\API;

use App\Events\NewImageUploadedEvent;
use App\User;
use App\Http\Controllers\Controller;
use App\Http\Resources\UsersResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->only(['profile']);
    }

    public function profile(): UsersResource
    {
        $user = auth('api')->user();
        $this->authorize('canEditUser', $user);
        return new UsersResource($user);
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        if(auth()->attempt(['email' => request('email'), 'password' => request('password')])){
            return response()->json([ 'data' => auth()->user()->passportToken ]);
        }
        return response()->json(['password' => trans('auth.failed')],422);
    }

    public function register(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|string|min:3',
            'email' => 'required|email|unique:users',
            'phone' => 'required|phone:AUTO',
            'password' => 'required|min:6|string|confirmed'
        ]);
        $request->merge([
            'password' => Hash::make($request['password']),
            'role' => $request['role'] ?: 'user'
        ]);
        $user = User::create($request->only(['name','email','password','phone','role']));
        if($request->image){
        	$params = [
				'image' => $request->image,
				'object' => $user,
				'path' => 'img/users/',
				'type' => 'App\User',
			];
        	event(new NewImageUploadedEvent($params));
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
