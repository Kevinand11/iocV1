<?php

namespace App\Http\Controllers\API;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth:api");
    }

    public function index()
    {
        return Category::orderBy("created_at","desc")->with("posts.user")->get();
    }

    public function paginate()
    {
        return Category::orderBy("created_at","desc")->with("posts.user")->paginate(10);
    }

    public function all()
    {
        return Category::orderBy("created_at","desc")->get();
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            "name" => "required|string|min:3|unique:categories",
            "parent" => "string"
        ]);
        return Category::create([
            "name" => $request["name"],
            "parent" => $request["parent"]
        ]);
    }

    public function show(Category $category)
    {
        return Category::where("id",$category->id)->with("posts.user")->first();
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
        return $category;
    }

    public function destroy(Category $category)
    {
        foreach ($category->posts as $post) {
            $post->delete();
        }
        if($category->delete()){
            return "true";
        }
        return "false";
    }
}
