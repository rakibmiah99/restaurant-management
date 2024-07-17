<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class CompanyUpdateRequest extends FormRequest
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
            'code' => 'required',
            'name' => 'required|string|max:25',
            'country_id' => 'required|exists:countries,id',
            'meal_price_id' => 'nullable|exists:meal_prices,id',
            'email' => 'nullable|email',
            'phone' => 'nullable|max:15',
            'address' => 'nullable',
            'agent_name' => 'nullable|string|max:25',
            'agent_mobile' => 'nullable|max:15',
            'status' => 'required',
        ];
    }
}
