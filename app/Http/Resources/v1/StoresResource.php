<?php /** @noinspection ALL */

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class StoresResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'email_verified_at' => $this->email_verified_at,
            'description' => $this->description,
            'link' => $this->link,
            'phone' => $this->phone,
            'user' => $this->user,
            'posts' => $this->posts,
            'picture' => $this->picture,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
