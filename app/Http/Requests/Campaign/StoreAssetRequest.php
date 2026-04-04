<?php

namespace App\Http\Requests\Campaign;

use Illuminate\Foundation\Http\FormRequest;

class StoreAssetRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'type' => 'required|in:before,after,reference,design',
            'file' => 'required|file|max:20480', // 20MB max
            'captured_at' => 'nullable|date',
        ];
    }
}
