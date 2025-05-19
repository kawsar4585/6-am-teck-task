<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class FileUploadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'file' => 'required|array',
            'file.*' => 'required|file|mimes:jpeg,png,jpg,pdf|max:5120',
        ];
    }
}
