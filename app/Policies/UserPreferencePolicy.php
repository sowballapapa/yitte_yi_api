<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserPreference;

class UserPreferencePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, UserPreference $userPreference): bool
    {
        return $user->isAdmin() || $user->id === $userPreference->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Handled automatically by UserObserver - never manually created
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, UserPreference $userPreference): bool
    {
        return $user->isAdmin() || $user->id === $userPreference->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, UserPreference $userPreference): bool
    {
        // Preferences are deleted via cascade when user is deleted
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, UserPreference $userPreference): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, UserPreference $userPreference): bool
    {
        return false;
    }
}
