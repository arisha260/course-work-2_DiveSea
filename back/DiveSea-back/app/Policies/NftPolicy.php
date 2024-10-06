<?php

namespace App\Policies;

use App\Models\Nft;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Log;

class NftPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        Log::info($user->role);
        return $user->role === 'admin' || $user->role === 'author';
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Nft $nft): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        Log::info('User Role: ' . $user->role); // Log the user's role
        return $user->role === 'admin' || $user->role === 'author';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Nft $nft): bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Nft $nft): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Nft $nft): bool
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Nft $nft): bool
    {
        return true;
    }

    public function buy(User $user, Nft $nft): bool
    {
        // Например, можно запретить покупку, если NFT уже куплено
        return $nft->owner_id === null;
    }
}
