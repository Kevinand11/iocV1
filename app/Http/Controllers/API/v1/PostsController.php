<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Requests\v1\PostCreateRequest;
use App\Http\Requests\v1\PostUpdateRequest;
use App\Post;
use App\Http\Resources\v1\PostsResource;
use App\Http\Controllers\Controller;
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

    public function store(PostCreateRequest $request)
    {
		if(!auth('api')->user()->store){
			return response()->json([ 'errors' => [ 'name' => 'User doesn\'t have an existing store' ] ],422);
		}
        $request->merge(['store_id' => auth('api')->user()->store->id ?: 0 ]);
        $post =  Post::create($request->only(['name','description','category_id','price','store_id']));
        return new PostsResource($post);
    }

    public function show(Post $post): PostsResource
    {
        $post = Post::where('id',$post->id)->with('category', 'store.user', 'pictures')->first();
        return new PostsResource($post);
    }

    public function update(PostUpdateRequest $request, Post $post): PostsResource
    {
        $post->update($request->only(['name','description','category_id','price']));
        return new PostsResource($post);
    }

    public function destroy(Post $post)
    {
        $this->authorize('canEditPost', $post);
		if(Post::destroy($post->id)){
            return response()->json(['success' => 'true']);
        }
        return response()->json(['error' => 'Record not found'],422);
    }
}
