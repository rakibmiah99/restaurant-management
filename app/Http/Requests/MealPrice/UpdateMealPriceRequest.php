<?php

namespace App\Http\Requests\MealPrice;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMealPriceRequest extends FormRequest
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
            'service_type' => 'required',
            'status' => 'required',
            'meal_systems' => 'required|array',
            'meal_systems.*' => 'required|exists:meal_systems,id',
            'meal_system_price' => 'required|array',
            'meal_system_price.*' => 'required',
        ];
    }
}
