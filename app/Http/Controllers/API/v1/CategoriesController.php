<?php

namespace App\Http\Controllers\API\v1;

use App\Category;
use App\Http\Requests\v1\CategoryCreateRequest;
use App\Http\Requests\v1\CategoryUpdateRequest;
use App\Http\Resources\v1\CategoriesResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CategoriesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['index', 'paginate', 'show']);
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

    public function store(CategoryCreateRequest $request): CategoriesResource
    {
        $category = Category::create($request->only(['name', 'parent_id']));
        return new CategoriesResource($category);
    }

    public function show(Category $category): CategoriesResource
    {
        $category = Category::where('id',$category->id)->with('posts.store.user','parent','subs')->first();
        return new CategoriesResource($category);
    }

    public function update(CategoryUpdateRequest $request, Category $category): CategoriesResource
    {
        $category->update($request->only(['name', 'parent_id']));
        return new CategoriesResource($category);
    }

    public function destroy(Category $category)
    {
        $this->authorize('canEditCategory');
		if(Category::destroy($category->id)){
            return response()->json(['success' => 'true']);
        }
        return response()->json(['error' => 'Record not found'],422);
    }
}
