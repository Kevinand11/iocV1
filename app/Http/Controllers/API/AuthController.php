<?php

namespace App\Http\Controllers\API;

use App\Picture;
use App\User;
use App\Http\Controllers\Controller;
use App\Http\Resources\UsersResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->only(['profile']);
    }

    public function profile(): UsersResource
    {
        $user = auth('api')->user();
        return  new UsersResource($user);
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
            return response()->json(['data' => Auth::user()->createToken('Auth Token')->accessToken ]);
        }
        return response()->json(['password' => trans('auth.failed')],422);
    }

    public function register(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|string|min:3',
            'email' => 'required|email|unique:users',
            'phone' => 'required',
            'password' => 'required|min:6|string|confirmed'
        ]);
        $request->merge([
            'password' => Hash::make($request['password']),
            'role' => $request['role'] ?: 'user'
        ]);
        $user = User::create($request->only(['name','email','password','phone','role']));
        if($request->image){
            $name = time().'.'.explode('/',explode(':',substr($request->image,0,
                    strpos($request->image,';')))[1])[1];
            $filename = public_path('img/users/').$name;
            Image::make($request->image)->save($filename);
            Picture::create([
                'imageable_id' => $user->id,
                'imageable_type' => 'App\User',
                'filename' => 'img/users/'.$name
            ]);
        }
        Auth::login($user);
        return response()->json(['data' => $user->createToken('Auth Token')->accessToken ]);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json(['success' => 'true']);
    }
}
