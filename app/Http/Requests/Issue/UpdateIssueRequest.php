<?php
namespace App\Http\Requests\Issue;

use Illuminate\Foundation\Http\FormRequest;

class UpdateIssueRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'title'       => 'optional|string|max:255',
            'description' => 'optional|nullable|string',
            'status'      => 'optional|nullable|in:open,in_progress,resolved,closed',
            'priority'    => 'optional|nullable|in:low,medium,high,urgent',
        ];
    }
}
