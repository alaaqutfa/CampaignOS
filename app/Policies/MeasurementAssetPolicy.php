<?php
namespace App\Policies;

use App\Models\CampaignItem;
use App\Models\MeasurementAsset;
use App\Models\User;

class MeasurementAssetPolicy
{
    public function view(User $user, CampaignItem $item): bool
    {
        if ($user->is_super_admin || $user->company_id === $item->campaign->company_id) {
            return true;
        }
        if ($user->hasRole('measurer') && $item->assigned_measurer_id === $user->id) {
            return true;
        }
        if ($user->hasRole('installer') && $item->assigned_installer_id === $user->id) {
            return true;
        }
        return false;
    }

    public function create(User $user, CampaignItem $item): bool
    {
        if ($user->is_super_admin || $user->company_id === $item->campaign->company_id) {
            return true;
        }
        if ($user->hasRole('measurer') && $item->assigned_measurer_id === $user->id) {
            return true;
        }
        if ($user->hasRole('installer') && $item->assigned_installer_id === $user->id) {
            return true;
        }
        return false;
    }

    public function delete(User $user, MeasurementAsset $asset): bool
    {
        $item = $asset->campaignItem;
        if ($user->is_super_admin || $user->company_id === $item->campaign->company_id) {
            return true;
        }
        if ($user->hasRole('measurer') && $item->assigned_measurer_id === $user->id) {
            return true;
        }
        if ($user->hasRole('installer') && $item->assigned_installer_id === $user->id) {
            return true;
        }
        return false;
    }
}
