<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DesignJobResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'campaign_id' => $this->campaign_id,
            'template_name' => $this->template_name,
            'input_payload' => $this->input_payload,
            'output_file' => $this->output_file ? asset('storage/' . $this->output_file) : null,
            'status' => $this->status,
            'error_message' => $this->error_message,
            'submitted_at' => $this->submitted_at?->toISOString(),
            'completed_at' => $this->completed_at?->toISOString(),
            'created_at' => $this->created_at->toISOString(),
        ];
    }
}
