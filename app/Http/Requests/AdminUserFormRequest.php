<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminUserFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Only super admins can manage admin users
        return auth()->user()?->isSuperAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $adminUser = $this->route('adminUser');
        
        // Build the email unique rule
        $emailRule = [
            'required',
            'string',
            'email',
            'max:255',
        ];
        
        // Add unique validation - ignore current user if editing
        if ($adminUser) {
            // If it's an object (model instance), use it directly
            // If it's a raw ID, convert to model or use ID
            if (is_object($adminUser)) {
                $emailRule[] = Rule::unique('users', 'email')->ignore($adminUser->id, 'id');
            } else {
                $emailRule[] = Rule::unique('users', 'email')->ignore($adminUser, 'id');
            }
        } else {
            // Creating new user - must be unique
            $emailRule[] = Rule::unique('users', 'email');
        }

        $rules = [
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'email' => $emailRule,
            'role' => [
                'required',
                'string',
                'in:admin,super_admin',
            ],
            'status' => [
                'required',
                'string',
                'in:active,inactive',
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
            'password.required' => 'The password field is required when creating a new user.',
            'password.min' => 'The password must be at least 8 characters.',
            'password.confirmed' => 'The password confirmation does not match.',
            'role.required' => 'The role field is required.',
            'role.in' => 'The role must be either admin or super_admin.',
            'status.required' => 'The status field is required.',
            'status.in' => 'The status must be either active or inactive.',
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
            'role' => 'role',
            'status' => 'status',
        ];
    }
}

