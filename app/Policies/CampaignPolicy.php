<?php

namespace App\Policies;

use App\Models\Campaign;
use App\Models\User;

class CampaignPolicy
{
    public function view(User $user, Campaign $campaign): bool
    {
        return $user->company_id === $campaign->company_id;
    }

    public function update(User $user, Campaign $campaign): bool
    {
        return $user->company_id === $campaign->company_id;
    }

    public function addMeasurement(User $user, Campaign $campaign): bool
    {
        return $user->company_id === $campaign->company_id;
    }

    public function delete(User $user, Campaign $campaign): bool
    {
        return $user->company_id === $campaign->company_id;
    }
}
