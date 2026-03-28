<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CampaignResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'client_name' => $this->client_name,
            'location' => $this->location,
            'status' => $this->status,
            'priority' => $this->priority,
            'due_date' => $this->due_date?->toDateString(),
            'created_by' => $this->creator->name,
            'created_at' => $this->created_at->toISOString(),
            'updated_at' => $this->updated_at->toISOString(),
            'measurements' => MeasurementResource::collection($this->whenLoaded('measurements')),
            'assets' => AssetResource::collection($this->whenLoaded('assets')),
            'workflows' => WorkflowResource::collection($this->whenLoaded('workflows')),
        ];
    }
}
