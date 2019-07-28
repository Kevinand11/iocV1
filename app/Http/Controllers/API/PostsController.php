<?php

namespace App\Http\Controllers\API;

use App\Post;
use App\Http\Resources\PostsResource;
use App\Http\Resources\PostsCollection;
use App\Http\Controllers\Controller;
use function GuzzleHttp\Promise\all;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PostsController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth:api')->except(['index', 'paginate', 'show']);
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

    public function store(Request $request): PostsResource
    {
        $this->validate($request,[
            'name' => 'required|string|min:3',
            'description' => 'string',
            'price' => 'required|numeric',
            'category_id' => 'required|numeric',
            'store_id' => 'required|numeric',
        ]);
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
        $post->update($request->only(['name','description','category_id','price','updated_at']));
        return new PostsResource($post);
    }

    public function destroy(Post $post)
    {
        if($post->delete()){
            return response()->json(['success' => 'true']);
        }
        return response()->json(['error' => 'false']);
    }
}
