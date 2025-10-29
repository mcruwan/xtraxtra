<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()?->isAdmin() || auth()->user()?->isSuperAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $categoryId = $this->route('category')?->id;

        return [
            'name' => [
                'required',
                'string',
                'max:100',
                'unique:categories,name' . ($categoryId ? ",$categoryId" : ''),
            ],
            'slug' => [
                'nullable',
                'string',
                'max:100',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
            ],
            'description' => [
                'nullable',
                'string',
                'max:1000',
            ],
            'wordpress_category_id' => [
                'nullable',
                'string',
                'max:255',
            ],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The category name is required.',
            'name.max' => 'The category name cannot exceed 100 characters.',
            'name.unique' => 'A category with this name already exists.',
            'slug.max' => 'The slug cannot exceed 100 characters.',
            'slug.regex' => 'The slug must contain only lowercase letters, numbers, and hyphens.',
            'description.max' => 'The description cannot exceed 1000 characters.',
            'wordpress_category_id.max' => 'The WordPress category ID cannot exceed 255 characters.',
        ];
    }

    /**
     * Get custom attributes for error messages.
     */
    public function attributes(): array
    {
        return [
            'name' => 'category name',
            'slug' => 'URL slug',
            'description' => 'category description',
            'wordpress_category_id' => 'WordPress category ID',
        ];
    }
}

