<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminNewsEditRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && (auth()->user()->isSuperAdmin() || auth()->user()->isAdmin());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content' => ['required', 'string'],
            'featured_image' => ['nullable', 'image', 'max:2048'],
            'categories' => ['required', 'integer', 'exists:categories,id'],
            'tag_names' => ['nullable', 'array'],
            'tag_names.*' => ['string', 'max:255'],
            'status' => ['nullable', 'in:draft,pending,approved,rejected,published,scheduled'],
            'scheduled_at' => ['nullable', 'date', 'required_if:status,scheduled'],
            'live_url' => ['nullable', 'url', 'max:500', 'required_if:status,published'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'categories.*' => 'category',
            'tag_names.*' => 'tag',
            'live_url' => 'live URL',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'featured_image.max' => 'The featured image must not be larger than 2MB.',
            'live_url.required_if' => 'The live URL is required when status is published.',
            'live_url.url' => 'The live URL must be a valid URL.',
            'scheduled_at.required_if' => 'The scheduled date is required when status is scheduled.',
        ];
    }
}
