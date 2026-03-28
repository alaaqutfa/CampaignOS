<?php

namespace App\Services;

use App\Models\Campaign;
use App\Models\DesignJob;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class DesignJobService
{
    protected string $pythonApiUrl;

    public function __construct()
    {
        $this->pythonApiUrl = config('services.python.api_url', 'http://localhost:5000');
    }

    /**
     * Create a new design job and send to Python service.
     */
    public function createJob(Campaign $campaign, string $templateName, array $payload, int $userId): DesignJob
    {
        $job = DesignJob::create([
            'campaign_id' => $campaign->id,
            'created_by' => $userId,
            'template_name' => $templateName,
            'input_payload' => $payload,
            'status' => 'pending',
            'submitted_at' => now(),
        ]);

        // Dispatch queue job to send to Python
        dispatch(new \App\Jobs\SendDesignToPython($job));

        return $job;
    }

    /**
     * Send job data to Python API.
     */
    public function sendToPython(DesignJob $job): void
    {
        try {
            $response = Http::timeout(60)
                ->post($this->pythonApiUrl . '/api/design', [
                    'job_id' => $job->id,
                    'template' => $job->template_name,
                    'payload' => $job->input_payload,
                    'callback_url' => route('api.design-jobs.callback', ['job' => $job->id]),
                ]);

            if ($response->successful()) {
                $job->update(['status' => 'processing']);
            } else {
                $this->markFailed($job, 'Python service returned error: ' . $response->body());
            }
        } catch (\Exception $e) {
            Log::error('Failed to send design job to Python', [
                'job_id' => $job->id,
                'error' => $e->getMessage(),
            ]);
            $this->markFailed($job, 'Connection error: ' . $e->getMessage());
        }
    }

    /**
     * Handle callback from Python service when design is ready.
     */
    public function handleCallback(DesignJob $job, array $data): void
    {
        if ($data['status'] === 'success') {
            // Store the generated file
            $fileUrl = $data['file_url'] ?? null;
            if ($fileUrl) {
                // Download file from Python service and store locally
                $fileContent = Http::get($fileUrl)->body();
                $fileName = 'design_' . $job->id . '_' . now()->timestamp . '.png';
                $path = 'campaigns/' . $job->campaign_id . '/designs/' . $fileName;
                Storage::disk('public')->put($path, $fileContent);

                $job->update([
                    'output_file' => $path,
                    'status' => 'completed',
                    'completed_at' => now(),
                ]);

                // Optionally create an asset record
                $job->campaign->assets()->create([
                    'type' => 'design',
                    'file_path' => $path,
                    'original_name' => $fileName,
                    'mime_type' => 'image/png', // or determine from file
                    'size' => Storage::disk('public')->size($path),
                    'uploaded_by' => $job->created_by,
                    'captured_at' => now(),
                ]);
            } else {
                $this->markFailed($job, 'No file URL provided in success response');
            }
        } else {
            $this->markFailed($job, $data['error'] ?? 'Unknown error');
        }
    }

    protected function markFailed(DesignJob $job, string $error): void
    {
        $job->update([
            'status' => 'failed',
            'error_message' => $error,
        ]);
    }
}
