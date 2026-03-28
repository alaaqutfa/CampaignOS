<?php

namespace App\Policies;

use App\Models\Shop;
use App\Models\User;

class ShopPolicy
{
    public function view(User $user, Shop $shop): bool
    {
        return $user->is_super_admin || $user->company_id === $shop->company_id;
    }

    public function create(User $user): bool
    {
        return $user->hasRole('company_admin') || $user->is_super_admin;
    }

    public function update(User $user, Shop $shop): bool
    {
        return $user->is_super_admin || $user->company_id === $shop->company_id;
    }

    public function delete(User $user, Shop $shop): bool
    {
        return $user->is_super_admin || $user->company_id === $shop->company_id;
    }
}
