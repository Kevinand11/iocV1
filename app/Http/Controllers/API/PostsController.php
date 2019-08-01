<?php

namespace App\Http\Controllers\API;

use App\Post;
use App\Http\Resources\PostsResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['index', 'paginate', 'show']);
    }

    public function index(): AnonymousResourceCollection
    {
        $posts = Post::latest()->with('category', 'store.user', 'pictures')->get();
        return PostsResource::collection($posts);
    }

    public function paginate(): AnonymousResourceCollection
    {
        $posts = Post::latest()->with('category', 'store.user', 'pictures')->paginate(10);
        return PostsResource::collection($posts);
    }

    public function store(Request $request)
    {
		if(!auth('api')->user()->store){
			return response()->json([ 'errors' => [ 'name' => 'User doesn\'t have an existing store' ] ],422);
		}
        $this->validate($request,[
            'name' => 'required|string|min:3',
            'description' => 'string',
            'price' => 'required|numeric',
            'category_id' => 'required|numeric',
        ]);
        $request->merge(['store_id' => auth('api')->user()->store->id ?: 0 ]);
        $post =  Post::create($request->only(['name','description','category_id','price','store_id']));
        return new PostsResource($post);
    }

    public function show(Post $post): PostsResource
    {
        $post = Post::where('id',$post->id)->with('category', 'store.user', 'pictures')->first();
        return new PostsResource($post);
    }

    public function update(Request $request, Post $post): PostsResource
    {
        $this->validate($request,[
            'name' => 'required|string|min:3',
            'description' => 'string',
            'category_id' => 'required|numeric',
            'price' => 'required|numeric'
        ]);
        $request->merge([ 'updated_at' => now() ]);
        $this->authorize('canEditPost', $post);
        $post->update($request->only(['name','description','category_id','price','updated_at']));
        return new PostsResource($post);
    }

    public function destroy(Post $post)
    {
        $this->authorize('canEditPost', $post);
        if($post->delete()){
            return response()->json(['success' => 'true']);
        }
        return response()->json(['error' => 'false']);
    }
}
