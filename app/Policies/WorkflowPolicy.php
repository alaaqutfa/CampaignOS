<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Workflow;

class WorkflowPolicy
{
    public function view(User $user, Workflow $workflow): bool
    {
        return $user->company_id === $workflow->campaign->company_id;
    }

    public function create(User $user, \App\Models\Campaign $campaign): bool
    {
        return $user->company_id === $campaign->company_id;
    }

    public function update(User $user, Workflow $workflow): bool
    {
        return $user->company_id === $workflow->campaign->company_id;
    }

    public function delete(User $user, Workflow $workflow): bool
    {
        return $user->company_id === $workflow->campaign->company_id;
    }
}
