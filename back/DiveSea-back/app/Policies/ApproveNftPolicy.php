<?php

namespace App\Policies;

use App\Models\ApproveNft;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ApproveNftPolicy
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
    public function view(User $user, ApproveNft $approveNft): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Только администратор может добавлять в таблицу ApproveNft
        return $user->role === 'admin' || $user->role === 'author';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ApproveNft $approveNft): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ApproveNft $approveNft): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ApproveNft $approveNft): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ApproveNft $approveNft): bool
    {
        //
    }
}
