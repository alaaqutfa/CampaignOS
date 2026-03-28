<?php

namespace App\Policies;

use App\Models\City;
use App\Models\User;

class CityPolicy
{
    public function view(User $user, City $city): bool
    {
        return $user->is_super_admin || $user->company_id === $city->company_id;
    }

    public function create(User $user): bool
    {
        return $user->hasRole('company_admin') || $user->is_super_admin;
    }

    public function update(User $user, City $city): bool
    {
        return $user->is_super_admin || $user->company_id === $city->company_id;
    }

    public function delete(User $user, City $city): bool
    {
        return $user->is_super_admin || $user->company_id === $city->company_id;
    }
}
