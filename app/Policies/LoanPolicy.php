<?php

namespace App\Policies;

use App\Models\User;

class LoanPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view loans');
    }

    public function view(User $user): bool
    {
        return $user->can('view loans');
    }

    public function create(User $user): bool
    {
        return $user->can('create loans');
    }

    public function update(User $user): bool
    {
        return $user->can('update loans');
    }

    public function delete(User $user): bool
    {
        return $user->can('delete loans');
    }

    public function restore(User $user): bool
    {
        return $user->can('restore loans');
    }

    public function forceDelete(User $user): bool
    {
        return $user->can('force delete loans');
    }
}
