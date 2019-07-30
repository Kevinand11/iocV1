<?php /** @noinspection NullPointerExceptionInspection */

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EditPolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
        //
    }

    public function canEditUser($user): bool
    {
        $auth = auth('api')->user();
        return $user->id === $auth->id || $auth->role === 'admin';
    }
    public function canEditStore($store): bool
    {
        $auth = auth('api')->user();
        return $store->user->id === $auth->id || $auth->role === 'admin';
    }

    public function canEditPost($post): bool
    {
        $auth = auth('api')->user();
        return $post->store->user->id === $auth->id || $auth->role === 'admin';
    }

    public function canEditCategory(): bool
    {
        $auth = auth('api')->user();
        return $auth->role === 'admin';
    }
}
