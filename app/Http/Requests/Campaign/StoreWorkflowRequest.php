<?php

namespace App\Http\Requests\Campaign;

use Illuminate\Foundation\Http\FormRequest;

class StoreWorkflowRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'stage' => 'required|in:design,print,install,review',
            'status' => 'required|in:pending,in_progress,completed,failed',
            'assigned_to' => 'nullable|exists:users,id',
        ];
    }
}
