<?php

namespace App\Http\Requests\DesignJob;

use Illuminate\Foundation\Http\FormRequest;

class StoreDesignJobRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'template_name' => 'required|string|max:255',
            'input_payload' => 'required|array',
        ];
    }
}
