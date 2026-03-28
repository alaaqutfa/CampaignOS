<?php

namespace App\Policies;

use App\Models\DesignJob;
use App\Models\User;

class DesignJobPolicy
{
    public function view(User $user, DesignJob $designJob): bool
    {
        return $user->isSuperAdmin() || $user->company_id === $designJob->campaign->company_id;
    }

    public function createDesignJob(User $user, Campaign $campaign): bool
    {
        return $user->company_id === $campaign->company_id;
    }
}
