<?php

namespace App\Http\Requests\SuperAdmin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->isSuperAdmin();
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'commercial_name' => 'nullable|string|max:255',
            'logo' => 'nullable|image|max:2048',
            'contact_info' => 'nullable|array',
            'status' => 'boolean',
        ];
    }
}
