<?php

namespace App\Policies;

use App\Models\User;

class BookPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view books');
    }

    public function view(User $user): bool
    {
        return $user->can('view books');
    }

    public function create(User $user): bool
    {
        return $user->can('create books');
    }

    public function update(User $user): bool
    {
        return $user->can('update books');
    }

    public function delete(User $user): bool
    {
        return $user->can('delete books');
    }

    public function restore(User $user): bool
    {
        return $user->can('restore books');
    }

    public function forceDelete(User $user): bool
    {
        return $user->can('force delete books');
    }
}
