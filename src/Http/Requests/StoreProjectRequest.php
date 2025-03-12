<?php

namespace Luinuxscl\PostPilot\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'slug' => 'required|string|max:8|unique:projects,slug',
            'name' => 'required|string|max:255',
            'editorial_line' => 'nullable|string',
            'target_audience' => 'nullable|string',
            'is_default' => 'boolean',
            'wordpress_credential_id' => 'nullable|exists:wordpress_credentials,id',
            'user_id' => 'nullable|exists:users,id',
        ];
    }
}
