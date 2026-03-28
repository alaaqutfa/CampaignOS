<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user)
    {
        // Super admin can see all users. Others only if they have a company.
        return $user->is_super_admin || $user->company_id !== null;
    }

    public function view(User $user, User $model)
    {
        if ($user->is_super_admin) {
            return true;
        }

        return $user->company_id === $model->company_id;
    }

    public function create(User $user)
    {
        // Only company_admin (or higher) can create users within their company.
        // We'll check role via Spatie.
        return $user->is_super_admin || $user->hasRole('company_admin') || $user->hasRole('platform_admin');
    }

    public function update(User $user, User $model)
    {
        if ($user->is_super_admin) {
            return true;
        }

        // Can only update users in same company and if user has role company_admin or higher.
        // But we need to ensure they can't update super_admin or platform_admin.
        if ($user->company_id !== $model->company_id) {
            return false;
        }

        return $user->hasRole('company_admin') || $user->hasRole('platform_admin');
    }

    public function delete(User $user, User $model)
    {
        if ($user->is_super_admin) {
            return true;
        }

        if ($user->company_id !== $model->company_id) {
            return false;
        }

        // Prevent deleting yourself.
        if ($user->id === $model->id) {
            return false;
        }

        return $user->hasRole('company_admin') || $user->hasRole('platform_admin');
    }
}
