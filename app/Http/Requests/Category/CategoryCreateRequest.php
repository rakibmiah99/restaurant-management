<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class CategoryCreateRequest extends FormRequest
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
            'unique_id' => 'required',
            'name' => 'required',
            'country_id' => 'required|exists:countries,id',
            'meal_price_id' => 'nullable|exists:meal_prices,id',
            'email' => 'nullable|email',
            'phone' => 'nullable',
            'address' => 'nullable',
            'agent_name' => 'nullable',
            'agent_mobile' => 'nullable',
            'status' => 'required',
        ];
    }
}
