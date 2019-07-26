<?php

namespace App\Http\Controllers\API;

use App\User;
use App\Http\Controllers\Controller;
use App\Http\Resources\UsersResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth:api")->only(["store","update","destroy"]);
    }

    public function index()
    {
        $users = User::latest()->with("posts.category")->get();
        return UsersResource::collection($users);
    }

    public function paginate()
    {
        $users = User::latest()->with("posts.category")->paginate(10);
        return UsersResource::collection($users);
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            "email" => 'required|string|email',
            'password' => 'required|string',
        ]);
        if(Auth::attempt(['email' => request("email"), 'password' => request("password")])){
            $user = Auth::user();
            $success["token"] = $user->createToken("Auth Token")->accessToken;
            $success["user"] = $user;
            return response()->json(["success"=>$success],200);
        }else{
            return response()->json(["password" => trans("auth.failed")],422);
        }
    }

    public function register(Request $request)
    {
        $this->validate($request,[
            "name" => "required|string|min:3",
            "email" => "required|email|unique:users",
            "phone" => "required",
            "password" => "required|min:6|string|confirmed"
        ]);
        $user = User::create([
            "name" => $request["name"],
            "email" => $request["email"],
            "phone" => $request["phone"],
            "password" => Hash::make($request["password"]),
            "role" => $request["role"] ?: "user"
        ]);
        Auth::login($user);
        $success["token"] = $user->createToken("Auth Token")->accessToken;
        $success["user"] = $user;
        return response()->json(["success"=>$success],200);
    }

    public function logout(){
        Auth::logout();
        return response()->json(["success"=>"true"]);
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            "name" => "required|string|min:3",
            "email" => "required|email|unique:users",
            "phone" => "required",
            "password" => "required|min:6|string|confirmed"
        ]);
        $user = User::create([
            "name" => $request["name"],
            "email" => $request["email"],
            "phone" => $request["phone"],
            "password" => Hash::make($request["password"]),
            "role" => $request["role"] ?: "user"
        ]);
        return new UsersResource($user);
    }

    public function show(User $user)
    {
        $user = User::where("id",$user->id)->with("posts.category")->first();
        return new UsersResource($user);
    }

    public function update(Request $request, User $user)
    {
        $this->validate($request,[
            "name" => "required|string|min:3",
            "email" => "required|email|unique:users,email,".$user->id,
            "password" => "sometimes|min:6|string|confirmed",
            "phone" => "required"
        ]);
        $user->update([
            "name" => $request["name"],
            "email" => $request["email"],
            "phone" => $request["phone"],
            "password" => Hash::make($request["password"]),
            "updated_at" => now()
        ]);
        if($request->has('role')){
            $user->role = $request["role"];
            $user->save();
        }
        return new UsersResource($user);
    }

    public function destroy(User $user)
    {
        foreach ($user->posts as $post) {
            $post->delete();
        }
        if($user->delete()){
            return response()->json(["success"=>"true"]);
        }
        return response()->json(["error"=>"false"]);
    }
}
