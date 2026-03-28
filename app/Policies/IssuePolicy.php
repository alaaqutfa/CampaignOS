<?php
namespace App\Policies;

use App\Models\Campaign;
use App\Models\Issue;
use App\Models\User;

class IssuePolicy
{
    public function view(User $user, Issue $issue): bool
    {
        return $user->isSuperAdmin() || $user->company_id === $issue->campaign->company_id;
    }

    public function createIssue(User $user, Campaign $campaign): bool
    {
        return $user->company_id === $campaign->company_id;
    }

    public function update(User $user, Issue $issue): bool
    {
        return $user->isSuperAdmin() || $user->company_id === $issue->campaign->company_id;
    }

    public function delete(User $user, Issue $issue): bool
    {
        return $user->isSuperAdmin() || $user->company_id === $issue->campaign->company_id;
    }
}
