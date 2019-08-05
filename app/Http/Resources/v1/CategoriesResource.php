<?php /** @noinspection ALL */

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoriesResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'parent' => $this->parent,
            'parent_id' => $this->parent_id,
            'subs' => $this->subs,
            'posts' => $this->posts,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
