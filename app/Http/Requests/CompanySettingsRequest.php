<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanySettingsRequest extends FormRequest
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
            'company_name' => 'required|string|max:255',
            'company_phone' => 'required',
            'company_email' => 'required|email',
            'company_address' => 'required|string',
            'company_website' => 'required|string',
            'tax' => 'required|numeric',
            'order_can_edit_before' => 'required|numeric',
            'file' => 'nullable|mimes:jpeg,jpg,png,gif|max:100000'
        ];
    }
}
