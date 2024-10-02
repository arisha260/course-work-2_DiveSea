<?php

namespace App\Policies;

use App\Models\ApproveAuthorship;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ApproveAuthorshipPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ApproveAuthorship $approveAuthorship): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user !== null;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ApproveAuthorship $authorshipRequest)
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ApproveAuthorship $approveAuthorship): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ApproveAuthorship $approveAuthorship): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ApproveAuthorship $approveAuthorship): bool
    {
        //
    }
}
