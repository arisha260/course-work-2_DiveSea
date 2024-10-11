<?php

namespace App\Http\Requests\EditProfile;

use Illuminate\Foundation\Http\FormRequest;

class EditNicknameBioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nickname' => 'nullable|string|unique:users,nickname,' . $this->user()->id . '|max:255',
            'bio' => 'nullable|string|max:255',
        ];
    }
}
