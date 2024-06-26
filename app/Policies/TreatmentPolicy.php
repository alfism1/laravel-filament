<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Treatment;
use App\Models\User;

class TreatmentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any Treatment');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Treatment $treatment): bool
    {
        return $user->checkPermissionTo('view Treatment');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create Treatment');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Treatment $treatment): bool
    {
        return $user->checkPermissionTo('update Treatment');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Treatment $treatment): bool
    {
        return $user->checkPermissionTo('delete Treatment');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Treatment $treatment): bool
    {
        return $user->checkPermissionTo('restore Treatment');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Treatment $treatment): bool
    {
        return $user->checkPermissionTo('force-delete Treatment');
    }
}
