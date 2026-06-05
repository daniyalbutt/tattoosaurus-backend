<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ArtistProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool { return true; }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'bio'         => ['required', 'string', 'max:2000'],
            'avatar'      => ['nullable', 'image', 'max:4096'],
            'portfolio'   => ['nullable', 'array', 'max:6'],
            'portfolio.*' => ['image', 'max:4096'],
        ];
    }
}
