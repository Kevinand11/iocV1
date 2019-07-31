<?php

namespace App\Http\Controllers\API;

use App\Events\NewImageUploadedEvent;
use App\Http\Resources\StoresResource;
use App\Picture;
use App\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Intervention\Image\ImageManagerStatic as Image;

class StoresController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->only(['store','update','destroy']);
    }

    public function index(): AnonymousResourceCollection
    {
        $stores = Store::latest()->with('posts.category', 'user', 'picture')->get();
        return StoresResource::collection($stores);
    }

    public function paginate(): AnonymousResourceCollection
    {
        $stores = Store::latest()->with('posts.category','user', 'picture')->paginate(10);
        return StoresResource::collection($stores);
    }

    public function store(Request $request): StoresResource
    {
        $this->validate($request,[
            'name' => 'required|string',
            'description' => 'string',
            'email' => 'required|email|unique:stores',
            'phone' => 'required',
            'link' => 'string',
        ]);
        $request->merge(['user_id' => auth('api')->user()->id ?: 0 ]);
        $store = Store::create($request->only(['name','description','email','phone','link','user_id']));
		if($request->image){
			$params = [
				'image' => $request->image,
				'object' => $store,
				'path' => 'img/stores/',
				'type' => 'App\Store',
			];
			event(new NewImageUploadedEvent($params));
		}
        return new StoresResource($store);
    }

    public function show(Store $store): StoresResource
    {
        $store = Store::where('id',$store->id)->with('posts.category','user', 'picture')->first();
        return new StoresResource($store);
    }

    public function update(Request $request, Store $store): StoresResource
    {
        $this->validate($request,[
            'name' => 'required|string',
            'description' => 'string',
            'email' => 'required|email|unique:stores,email,' .$store->id,
            'phone' => 'required',
            'link' => 'string',
        ]);
        $request->merge([
            'updated_at' => now(),
        ]);
        $this->authorize('canEditStore', $store);
        $store->update($request->only(['name','description','email','phone','link','updated_at']));
		if($request->image){
			$params = [
				'image' => $request->image,
				'object' => $store,
				'path' => 'img/stores/',
				'type' => 'App\Store',
			];
			event(new NewImageUploadedEvent($params));
		}
        return new StoresResource($store);
    }

    public function destroy(Store $store)
    {
        $this->authorize('canEditStore', $store);
        if($store->delete()){
            return response()->json(['success' => 'true']);
        }
        return response()->json(['error' => 'false']);
    }
}
