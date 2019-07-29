<?php /** @noinspection ALL */

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PicturesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request): Array
    {
        return [
            'id' => $this->id,
            'filename' => $this->filename,
            'imageable_type' => $this->imageable_type,
            'imageable_id' => $this->imageable_id,
            'imageable' => $this->imageable,
        ];
    }
}
