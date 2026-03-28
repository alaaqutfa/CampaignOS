<?php

namespace App\Http\Controllers;

use App\Http\Requests\Campaign\StoreWorkflowRequest;
use App\Http\Resources\WorkflowResource;
use App\Models\Campaign;
use App\Models\Workflow;

class WorkflowController extends Controller
{
    public function index(Campaign $campaign): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $this->authorize('view', $campaign);
        return WorkflowResource::collection($campaign->workflows()->with('assignee')->get());
    }

    public function store(StoreWorkflowRequest $request, Campaign $campaign): WorkflowResource
    {
        $this->authorize('createWorkflow', $campaign);
        $workflow = $campaign->workflows()->create([
            'stage' => $request->stage,
            'status' => $request->status,
            'assigned_to' => $request->assigned_to,
            'started_at' => $request->status === 'in_progress' ? now() : null,
        ]);
        return new WorkflowResource($workflow->load('assignee'));
    }

    public function show(Campaign $campaign, Workflow $workflow): WorkflowResource
    {
        $this->authorize('view', $workflow);
        return new WorkflowResource($workflow->load('assignee'));
    }

    public function update(StoreWorkflowRequest $request, Campaign $campaign, Workflow $workflow): WorkflowResource
    {
        $this->authorize('update', $workflow);
        $data = $request->validated();
        if ($request->status === 'in_progress' && !$workflow->started_at) {
            $data['started_at'] = now();
        }
        if ($request->status === 'completed' && !$workflow->completed_at) {
            $data['completed_at'] = now();
        }
        $workflow->update($data);
        return new WorkflowResource($workflow->fresh()->load('assignee'));
    }

    public function destroy(Campaign $campaign, Workflow $workflow): \Illuminate\Http\JsonResponse
    {
        $this->authorize('delete', $workflow);
        $workflow->delete();
        return response()->json(['message' => 'Workflow entry deleted successfully.']);
    }
}
