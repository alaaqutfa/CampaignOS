<?php

namespace App\Policies;

use App\Models\User;

class RolePolicy
{
    /**
     * Allow only super admins to manage roles.
     */
    public function before(User $user, $ability): bool|null
    {
        if ($user->hasRole('super_admin')) {
            return true;
        }
        return null;
    }

    /**
     * Determine whether the user can view any roles.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('super_admin');
    }

    /**
     * Determine whether the user can create roles.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('super_admin');
    }

    /**
     * Determine whether the user can update a role.
     */
    public function update(User $user, $role): bool
    {
        return $user->hasRole('super_admin');
    }

    /**
     * Determine whether the user can delete a role.
     */
    public function delete(User $user, $role): bool
    {
        // Prevent deletion of critical roles
        if (in_array($role->name, ['super_admin', 'platform_admin'])) {
            return false;
        }
        return $user->hasRole('super_admin');
    }
}
