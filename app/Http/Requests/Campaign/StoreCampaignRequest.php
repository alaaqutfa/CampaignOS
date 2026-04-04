<?php

namespace App\Http\Requests\Campaign;

use Illuminate\Foundation\Http\FormRequest;

class StoreCampaignRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'client_id' => 'nullable|exists:clients,id',
            'location' => 'nullable|string|max:500',
            'status' => 'nullable|in:draft,active,completed,archived',
            'priority' => 'nullable|in:low,medium,high,urgent',
            'due_date' => 'nullable|date',
        ];
    }
}
