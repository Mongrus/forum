<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

class PostCreateRequest extends FormRequest
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
            'title' => 'required|string|min:5|max:30',
            'description' => 'required|string|min:10|max:3000',
            'section_id' => 'required|integer|exists:sections,id',
            'theme_id' => 'nullable|integer|exists:themes,id|required_without:custom_theme',
            'custom_theme' => 'nullable|string|min:5|max:30|required_without:theme_id',
        ];
    }
}
