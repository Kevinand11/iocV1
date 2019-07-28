<?php /** @noinspection ALL */

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostsResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'store' => $this->store,
            'category' => $this->category,
            'category_id' => $this->category_id,
            'pictures' => $this->pictures,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
