<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UniversityUserFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Only admins/super admins can manage university users
        return auth()->user()?->isAdmin() || auth()->user()?->isSuperAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $userId = $this->route('universityUser')?->id;

        $rules = [
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email' . ($userId ? ",$userId" : ''),
            ],
            'university_id' => [
                'required',
                'exists:universities,id',
            ],
            'status' => [
                'required',
                'string',
                'in:active,inactive,pending',
            ],
        ];

        // Password is required on create, optional on update
        if ($this->isMethod('post')) {
            $rules['password'] = [
                'required',
                'string',
                'min:8',
                'confirmed',
            ];
        } else {
            $rules['password'] = [
                'nullable',
                'string',
                'min:8',
                'confirmed',
            ];
        }

        return $rules;
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The name field is required.',
            'name.max' => 'The name cannot exceed 255 characters.',
            'email.required' => 'The email field is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already in use.',
            'email.max' => 'The email cannot exceed 255 characters.',
            'university_id.required' => 'Please select a university.',
            'university_id.exists' => 'The selected university does not exist.',
            'password.required' => 'The password field is required when creating a new user.',
            'password.min' => 'The password must be at least 8 characters.',
            'password.confirmed' => 'The password confirmation does not match.',
            'status.required' => 'The status field is required.',
            'status.in' => 'The status must be active, inactive, or pending.',
        ];
    }

    /**
     * Get custom attributes for error messages.
     */
    public function attributes(): array
    {
        return [
            'name' => 'name',
            'email' => 'email',
            'password' => 'password',
            'university_id' => 'university',
            'status' => 'status',
        ];
    }
}

