<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Issue\StoreIssueRequest;
use App\Http\Requests\Issue\UpdateIssueRequest;
use App\Http\Resources\IssueResource;
use App\Models\Campaign;
use App\Models\Issue;
use Illuminate\Http\Request;

class IssueController extends Controller
{
    public function index(Request $request)
    {
        $user   = $request->user();
        $issues = Issue::whereHas('campaign', function ($q) use ($user) {
            $q->where('company_id', $user->company_id);
        })
            ->with(['campaign', 'reporter'])
            ->latest()
            ->paginate(15);

        return IssueResource::collection($issues);
    }

    public function store(StoreIssueRequest $request, Campaign $campaign)
    {
        $this->authorize('createIssue', $campaign);

        $issue = $campaign->issues()->create([
            'title'       => $request->title,
            'description' => $request->description,
            'status'      => $request->status ?? 'open',
            'priority'    => $request->priority ?? 'medium',
            'reported_by' => $request->user()->id,
        ]);

        return new IssueResource($issue->load('campaign', 'reporter'));
    }

    public function show(Issue $issue)
    {
        $this->authorize('view', $issue);
        return new IssueResource($issue->load('campaign', 'reporter'));
    }

    public function update(UpdateIssueRequest $request, Issue $issue)
    {
        $this->authorize('update', $issue);
        $issue->update($request->validated());
        return new IssueResource($issue->fresh()->load('campaign', 'reporter'));
    }

    public function destroy(Issue $issue)
    {
        $this->authorize('delete', $issue);
        $issue->delete();
        return response()->json(['message' => 'Issue deleted successfully.']);
    }
}
