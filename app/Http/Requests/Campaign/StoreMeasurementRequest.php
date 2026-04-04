<?php

namespace App\Http\Requests\Campaign;

use Illuminate\Foundation\Http\FormRequest;

class StoreMeasurementRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'width' => 'required|numeric|min:0',
            'height' => 'required|numeric|min:0',
            'unit' => 'required|in:cm,inch,pixel',
            'notes' => 'nullable|string',
        ];
    }
}
