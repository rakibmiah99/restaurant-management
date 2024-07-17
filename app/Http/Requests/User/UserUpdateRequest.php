<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            'name' => 'required|string|max:25',
            'email' => 'required|email',
            'phone' => 'nullable|max:15',
            'location' => 'nullable',
            'website' => 'nullable',
            'password' => 'nullable|min:6|max:12|same:confirm_password',
            'role_id' => 'required|exists:roles,id'
        ];
    }
}
