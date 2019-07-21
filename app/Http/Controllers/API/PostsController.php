<?php

namespace App\Http\Controllers\API;

use App\Post;
use App\Http\Resources\PostsResource;
use App\Http\Resources\PostsCollection;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth:api")->except(["index","paginate","show"]);
    }

    public function index()
    {
        $posts = Post::latest()->with("category","user")->get();
        return PostsResource::collection($posts);
    }

    public function paginate()
    {
        $posts = Post::latest()->with("category","user")->paginate(10);
        return PostsResource::collection($posts);
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            "name" => "required|string|min:3",
            "desciption" => "string",
            "price" => "required|numeric",
            "category_id" => "required|numeric"
        ]);
        $post =  Post::create([
            "name" => $request["name"],
            "description" => $request["description"],
            "price" => $request["price"],
            "category_id" => $request["category_id"],
            "user_id" => auth()->user()->id
        ]);
        return new PostsResource($post);
    }

    public function show(Post $post)
    {
        $post = Post::where("id",$post->id)->with("category","user")->first();
        return new PostsResource($post);
    }

    public function update(Request $request, Post $post)
    {
        $this->validate($request,[
            "name" => "required|string|min:3",
            "desciption" => "string",
            "category_id" => "required|numeric",
            "price" => "required|numeric"
        ]);
        $post->update([
            "name" => $request["name"],
            "description" => $request["description"],
            "price" => $request["price"],
            "category_id" => $request["category_id"],
            "updated_at" => now()
        ]);
        return new PostsResource($post);
    }

    public function destroy(Post $post)
    {
        if($post->delete()){
            return response()->json(["success"=>"true"]);
        }
        return response()->json(["error"=>"false"]);
    }
}
