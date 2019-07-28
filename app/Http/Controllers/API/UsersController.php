<?php

namespace App\Http\Controllers\API;

use App\Picture;
use App\User;
use App\Http\Controllers\Controller;
use App\Http\Resources\UsersResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;

class UsersController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth:api')->only(['store','update','destroy']);
    }

    public function index(): AnonymousResourceCollection
    {
        $users = User::latest()->with('store.posts.category', 'picture')->get();
        return UsersResource::collection($users);
    }

    public function paginate(): AnonymousResourceCollection
    {
        $users = User::latest()->with('store.posts.category', 'picture')->paginate(10);
        return UsersResource::collection($users);
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
            $user = Auth::user();
            //$user->merge(['apiToken' => $user->createToken('Auth Token')->accessToken]);
            return new UsersResource($user);
        }
        return response()->json(['password' => trans('auth.failed')],422);
    }

    public function register(Request $request): UsersResource
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
            $filename = public_path('img\\users\\').$name;
            Image::make($request->image)->save($filename);
            Picture::create([
                'imageable_id' => $user->id,
                'imageable_type' => 'App\User',
                'filename' => 'img/users/'.$name
            ]);
        }
        Auth::login($user);
        //$user->merge(['apiToken' => $user->createToken('Auth Token')->accessToken]);
        return new UsersResource($user);
    }

    public function logout(){
        Auth::logout();
        return response()->json(['success' => 'true']);
    }

    public function store(Request $request): UsersResource
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
            $filename = public_path('img\\users\\').$name;
            Image::make($request->image)->save($filename);
            Picture::create([
                'imageable_id' => $user->id,
                'imageable_type' => 'App\User',
                'filename' => 'img/users/'.$name
            ]);
        }
        return new UsersResource($user);
    }

    public function show(User $user): UsersResource
    {
        $user = User::where('id',$user->id)->with('store.posts.category', 'picture')->first();
        return new UsersResource($user);
    }

    public function update(Request $request, User $user): UsersResource
    {
        $this->validate($request,[
            'name' => 'required|string|min:3',
            'email' => 'required|email|unique:users,email,' .$user->id,
            'password' => 'sometimes|min:6|string|confirmed',
            'phone' => 'required'
        ]);
        $request->merge([
            'role' => $request['role'] ?: $user->role,
            'updated_at' => now()
        ]);
        $user->update($request->only(['name','email','phone','role','updated_at']));
        if($request->password){
            $user->update(['password' => Hash::make($request['password'])]);
        }
        if($request->image){
            $name = time().'.'.explode('/',explode(':',substr($request->image,0,
                    strpos($request->image,';')))[1])[1];
            $filename = public_path('img\\users\\').$name;
            Image::make($request->image)->save($filename);
            if($user->picture){
                $user->picture->update(['filename' => 'img/users/'.$name]);
            }else{
                Picture::create([
                    'imageable_id' => $user->id,
                    'imageable_type' => 'App\User',
                    'filename' => 'img/users/'.$name
                ]);
            }
        }
        return new UsersResource($user);
    }

    public function destroy(User $user)
    {
        if($user->store) {
            foreach ($user->store->posts as $post) {
                $post->delete();
            }
            $user->store->delete();
        }

        if($user->delete()){
            return response()->json(['success' => 'true']);
        }
        return response()->json(['error' => 'false']);
    }
}
