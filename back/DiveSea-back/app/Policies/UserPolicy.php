<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        //
    }

    public function deductTheBalance(User $user): bool
    {
        // Разрешаем действие, если пользователь имеет одну из допустимых ролей
        return in_array($user->role, ['admin', 'author', 'user']);
    }

    // Политика доступа для обновления аватара
    public function updateUserAvatar(User $user, User $model): bool
    {
        return $model->id === $user->id || $user->role === 'admin';
    }

// Политика доступа для обновления фоновой картинки
    public function updateUserBackground(User $user, User $model): bool
    {
        return $model->id === $user->id || $user->role === 'admin';
    }

    public function updateUserNicknameBio(User $user, User $model): bool
    {
        return $model->id === $user->id || $user->role === 'admin';
    }


    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        //
    }
}
