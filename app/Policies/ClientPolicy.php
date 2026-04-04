<?php
namespace App\Policies;

use App\Models\User;

class ClientPolicy
{
    public function viewAny(User $user)
    {
        return $user->company_id !== null;
    }
    public function view(User $user)
    {
        return $user->hasRole('company_admin');
    }
    public function create(User $user)
    {
        return $user->hasRole('company_admin');
    }
}
