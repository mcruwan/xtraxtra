<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NewsSubmissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isUniversityUser();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Get the news submission from route (parameter is 'news' for resource routes)
        $newsSubmission = $this->route('news');
        $newsSubmissionId = $newsSubmission ? (is_object($newsSubmission) ? $newsSubmission->id : $newsSubmission) : null;

        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('news_submissions')->ignore($newsSubmissionId)],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content' => ['required', 'string'],
            'featured_image' => ['nullable', 'image', 'max:2048'], // 2MB max
            'categories' => ['required', 'integer', 'exists:categories,id'],
            'tag_names' => ['nullable', 'array'],
            'tag_names.*' => ['string', 'max:255'],
            'status' => ['sometimes', 'in:draft,pending'],
            'scheduled_at' => ['nullable', 'date'],
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
            'tags.*' => 'tag',
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
        ];
    }
}
