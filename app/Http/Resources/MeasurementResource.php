<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MeasurementResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'width' => $this->width,
            'height' => $this->height,
            'unit' => $this->unit,
            'notes' => $this->notes,
            'recorded_by' => $this->recorder->name,
            'recorded_at' => $this->created_at->toISOString(),
        ];
    }
}
