<?php
namespace App\Policies;

use App\Models\Campaign;
use App\Models\CampaignItem;
use App\Models\User;

class CampaignItemPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->is_super_admin || $user->company_id !== null;
    }

    public function view(User $user, CampaignItem $item): bool
    {
        return $user->is_super_admin || $user->company_id === $item->campaign->company_id;
    }

    public function create(User $user, Campaign $campaign): bool
    {
        return $user->is_super_admin || $user->company_id === $campaign->company_id;
    }

    public function update(User $user, CampaignItem $item): bool
    {
        // السوبر أدمن أو مدير الشركة
        if ($user->is_super_admin || $user->company_id === $item->campaign->company_id) {
            return true;
        }
        // السماح للمقاول المكلف بالقياس
        if ($user->hasRole('measurer') && $item->assigned_measurer_id === $user->id) {
            return true;
        }
        // السماح للمقاول المكلف بالتركيب
        if ($user->hasRole('installer') && $item->assigned_installer_id === $user->id) {
            return true;
        }
        return false;
    }

    public function delete(User $user, CampaignItem $item): bool
    {
        return $user->is_super_admin || $user->company_id === $item->campaign->company_id;
    }

    public function restore(User $user, CampaignItem $item): bool
    {
        return $user->is_super_admin;
    }

    public function forceDelete(User $user, CampaignItem $item): bool
    {
        return $user->is_super_admin;
    }
}
