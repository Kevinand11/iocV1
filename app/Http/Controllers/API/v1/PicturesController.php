<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Requests\v1\PictureCreateRequest;
use App\Http\Requests\v1\PictureUpdateRequest;
use App\Http\Resources\v1\PicturesResource;
use App\Picture;
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

    public function store(PictureCreateRequest $request): PicturesResource
    {
        $picture = Picture::create($request->only(['filename', 'imageable_type', 'imageable_id']));
        return new PicturesResource($picture);
    }

    public function show(Picture $picture): PicturesResource
    {
        $picture = Picture::where('id',$picture->id)->with('imageable')->first();
        return new PicturesResource($picture);
    }

    public function update(PictureUpdateRequest $request, Picture $picture): PicturesResource
    {
        $picture->update($request->only(['filename', 'imageable_type', 'imageable_id']));
        return new PicturesResource($picture);
    }

    public function destroy(Picture $picture)
    {
        if(Picture::destroy($picture->id)){
			return response()->json(['success' => 'true']);
		}
		return response()->json(['error' => 'Record not found'],422);
    }
}
