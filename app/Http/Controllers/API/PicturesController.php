<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\PicturesResource;
use App\Picture;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PicturesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->only(['store','update','destroy']);
    }

    public function index(): AnonymousResourceCollection
    {
        $pictures = Picture::latest()->with('imageable')->get();
        return PicturesResource::collection($pictures);
    }

    public function paginate(): AnonymousResourceCollection
    {
        $pictures = Picture::latest()->with('imageable')->paginate(10);
        return PicturesResource::collection($pictures);
    }

    public function store(Request $request): PicturesResource
    {
        $this->validate($request,[
            'filename' => 'required|string',
            'imageable_type' => 'required|string',
            'imageable_id' => 'required|numeric',
        ]);
        $picture = Picture::create($request->only(['filename', 'imageable_type', 'imageable_id']));
        return new PicturesResource($picture);
    }

    public function show(Picture $picture): PicturesResource
    {
        $picture = Picture::where('id',$picture->id)->with('imageable')->first();
        return new PicturesResource($picture);
    }

    public function update(Request $request, Picture $picture): PicturesResource
    {
        $this->validate($request,[
            'filename' => 'required|string',
            'imageable_type' => 'required|string',
            'imageable_id' => 'required|numeric',
        ]);
        $request->merge([
            'updated_at' => now(),
        ]);
        $picture->update($request->only(['filename', 'imageable_type', 'imageable_id', 'updated_at']));
        return new PicturesResource($picture);
    }

    public function destroy(Picture $picture)
    {
        if($picture->delete()){
            return response()->json(['success' => 'true']);
        }
        return response()->json(['error' => 'false']);
    }
}
