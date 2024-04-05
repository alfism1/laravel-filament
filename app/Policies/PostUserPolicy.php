<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\PostUser;
use App\Models\User;

class PostUserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any PostUser');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, PostUser $postuser): bool
    {
        return $user->checkPermissionTo('view PostUser');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create PostUser');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PostUser $postuser): bool
    {
        return $user->checkPermissionTo('update PostUser');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PostUser $postuser): bool
    {
        return $user->checkPermissionTo('delete PostUser');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, PostUser $postuser): bool
    {
        return $user->checkPermissionTo('restore PostUser');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, PostUser $postuser): bool
    {
        return $user->checkPermissionTo('force-delete PostUser');
    }
}
