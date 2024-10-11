<?php

namespace App\Http\Requests\EditProfile;

use Illuminate\Foundation\Http\FormRequest;

class EditBgRequest extends FormRequest
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
            'background' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg', // Разрешенные форматы (webp исключен)
                'max:5120', // Максимальный размер файла — 5MB
                function ($attribute, $value, $fail) {
                    // Проверка минимальной ширины изображения (≥ 1200)
                    if ($value && !$this->imageHasMinWidth($value, 1200)) {
                        $fail('The background image must be at least 1200px in width.');
                    }
                },
            ],
        ];
    }

    protected function imageHasMinWidth($image, $minWidth): bool
    {
        list($width, $height) = getimagesize($image->getPathname());
        return $width >= $minWidth;
    }
}
