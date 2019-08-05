<?php /** @noinspection ALL */

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class PicturesResource extends JsonResource
{
    public function toArray($request): array
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
