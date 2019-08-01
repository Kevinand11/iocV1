<?php

namespace App\Http\Controllers\API;

use App\Events\NewImageUploadedEvent;
use App\User;
use App\Http\Controllers\Controller;
use App\Http\Resources\UsersResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->only(['store','update','destroy']);
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

    public function store(Request $request): UsersResource
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
            'phone' => 'required|phone:AUTO'
        ]);
        $request->merge([
            'role' => $request['role'] ?: $user->role,
            'updated_at' => now()
        ]);
        $this->authorize('canEditUser', $user);
        $user->update($request->only(['name','email','phone','role','updated_at']));
        if($request->password){
            $user->update(['password' => Hash::make($request['password'])]);
        }
		if($request->image){
			$params = [
				'image' => $request->image,
				'object' => $user,
				'path' => 'img/users/',
				'type' => 'App\User',
			];
			event(new NewImageUploadedEvent($params));
		}
        return new UsersResource($user);
    }

    public function destroy(User $user)
    {
        $this->authorize('canEditUser', $user);
        if($user->delete()){
            return response()->json(['success' => 'true']);
        }
        return response()->json(['error' => 'false']);
    }
}
