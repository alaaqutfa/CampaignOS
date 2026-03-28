<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DesignJob\StoreDesignJobRequest;
use App\Http\Resources\DesignJobResource;
use App\Models\Campaign;
use App\Models\DesignJob;
use App\Services\DesignJobService;
use Illuminate\Http\Request;

class DesignJobController extends Controller
{
    protected DesignJobService $designJobService;

    public function __construct(DesignJobService $designJobService)
    {
        $this->designJobService = $designJobService;
    }

    public function store(StoreDesignJobRequest $request, Campaign $campaign)
    {
        $this->authorize('createDesignJob', $campaign);

        $job = $this->designJobService->createJob(
            $campaign,
            $request->template_name,
            $request->input_payload,
            $request->user()->id
        );

        return new DesignJobResource($job);
    }

    public function show(DesignJob $designJob)
    {
        $this->authorize('view', $designJob);

        return new DesignJobResource($designJob);
    }

    public function callback(Request $request)
    {
        $validated = $request->validate([
            'job_id' => 'required|exists:design_jobs,id',
            'status' => 'required|in:success,failed',
            'file_url' => 'nullable|url',
            'error' => 'nullable|string',
        ]);

        $job = DesignJob::findOrFail($validated['job_id']);
        $this->designJobService->handleCallback($job, $validated);

        return response()->json(['message' => 'Callback processed']);
    }
}
