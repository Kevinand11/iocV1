<?php /** @noinspection PhpUndefinedFieldInspection */

namespace App\Http\Resources\v1;

use App\Store;
use Illuminate\Http\Resources\Json\JsonResource;

class UsersResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'email_verified_at' => $this->email_verified_at,
            'role' => $this->role,
            'phone' => $this->phone,
            'store' => $this->store,
            'picture' => $this->picture,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
