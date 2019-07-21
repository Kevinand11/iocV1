<?php

namespace App\Http\Controllers\API;

use App\Category;
use App\Http\Resources\CategoriesResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth:api")->except(["index","paginate","show"]);
    }

    public function index()
    {
        $categories = Category::latest()->with("posts.user")->get();
        return CategoriesResource::collection($categories);
    }

    public function paginate()
    {
        $categories = Category::latest()->with("posts.user")->paginate(10);
        return CategoriesResource::collection($categories);
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            "name" => "required|string|min:3|unique:categories",
            "parent" => "string"
        ]);
        $category = Category::create([
            "name" => $request["name"],
            "parent" => $request["parent"]
        ]);
        return new CategoriesResource($category);
    }

    public function show(Category $category)
    {
        $category = Category::where("id",$category->id)->with("posts.user")->first();
        return new CategoriesResource($category);
    }

    public function update(Request $request, Category $category)
    {
        $this->validate($request,[
            "name" => "required|string|min:3|unique:categories,name,".$category->id,
            "parent" => "string"
        ]);
        $category->update([
            "name" => $request["name"],
            "parent" => $request["parent"],
            "updated_at" => now()
        ]);
        return new CategoriesResource($category);
    }

    public function destroy(Category $category)
    {
        foreach ($category->posts as $post) {
            $post->delete();
        }
        if($category->delete()){
            return response()->json(["success"=>"true"]);
        }
        return response()->json(["error"=>"false"]);
    }
}
