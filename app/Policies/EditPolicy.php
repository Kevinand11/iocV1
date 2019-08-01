<?php /** @noinspection NullPointerExceptionInspection */

namespace App\Policies;

use App\Post;
use App\User;
use App\Store;
use Illuminate\Auth\Access\HandlesAuthorization;

class EditPolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
        //
    }

    public function canEditUser(User $auth, User $user): bool
    {
        return $user->id === $auth->id || $auth->role === 'admin';
    }
    public function canEditStore(User $auth, Store $store): bool
    {
        return $store->user->id === $auth->id || $auth->role === 'admin';
    }

    public function canEditPost(User $auth, Post $post): bool
    {
        return $post->store->user->id === $auth->id || $auth->role === 'admin';
    }

    public function canEditCategory(User $auth): bool
    {
        return $auth->role === 'admin';
    }
}
