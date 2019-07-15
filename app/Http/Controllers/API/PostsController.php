<?php

namespace App\Http\Controllers\API;

use App\Post;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth:api");
    }

    public function index()
    {
        return Post::orderBy("created_at","desc")->with("category","user")->get();
    }

    public function paginate()
    {
        return Post::orderBy("created_at","desc")->with("category","user")->paginate(10);
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            "name" => "required|string|min:3",
            "desciption" => "string",
            "price" => "numeric",
            "category_id" => "required"
        ]);
        return Post::create([
            "name" => $request["name"],
            "description" => $request["description"],
            "price" => $request["price"],
            "category_id" => $request["category_id"],
            "user_id" => auth()->user()->id
        ]);
    }

    public function show(Post $post)
    {
        return Post::where("id",$post->id)->with("category","user")->with("user")->first();
    }

    public function update(Request $request, Post $post)
    {
        $this->validate($request,[
            "name" => "required|string|min:3",
            "desciption" => "string",
            "category_id" => "required|numeric",
            "price" => "numeric"
        ]);
        $post->update([
            "name" => $request["name"],
            "description" => $request["description"],
            "price" => $request["price"],
            "category_id" => $request["category_id"],
            "updated_at" => now()
        ]);
        return $post;
    }

    public function destroy(Post $post)
    {   
        if($post->delete()){
            return "true";
        }
        return "false";
    }
}
