<?php

namespace App\Http\Controllers\API;

use App\Category;
use App\Http\Resources\CategoriesResource;
use App\Http\Controllers\Controller;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CategoriesController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth:api')->except(['index', 'paginate', 'show']);
    }

    public function index(): AnonymousResourceCollection
    {
        $categories = Category::latest()->with('posts.store.user','parent','subs')->get();
        return CategoriesResource::collection($categories);
    }

    public function paginate(): AnonymousResourceCollection
    {
        $categories = Category::latest()->with('posts.store.user','parent','subs')->paginate(10);
        return CategoriesResource::collection($categories);
    }

    public function store(Request $request): CategoriesResource
    {
        $this->validate($request,[
            'name' => 'required|string|min:3|unique:categories',
            'parent_id' => 'numeric|required'
        ]);
        $category = Category::create($request->all());
        return new CategoriesResource($category);
    }

    public function show(Category $category): CategoriesResource
    {
        $category = Category::where('id',$category->id)->with('posts.store.user','parent','subs')->first();
        return new CategoriesResource($category);
    }

    public function update(Request $request, Category $category): CategoriesResource
    {
        $this->validate($request,[
            'name' => 'required|string|min:3|unique:categories,name,' .$category->id,
            'parent_id' => 'numeric|required'
        ]);
        $request->merge([ 'updated_at' => now() ]);
        $category->update($request->all());
        return new CategoriesResource($category);
    }

    public function destroy(Category $category)
    {
        foreach ($category->posts as $post) {
            $post->delete();
        }
        foreach ($category->subs as $sub) {
            foreach ($sub->posts as $post) {
                $post->delete();
            }
            $sub->delete();
        }

        if($category->delete()){
            return response()->json(['success' => 'true']);
        }
        return response()->json(['error' => 'false']);
    }
}
