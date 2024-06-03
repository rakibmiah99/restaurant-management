<?php

namespace App\Http\Requests\Order;

use App\ServiceType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateOrderRequest extends FormRequest
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
            'order_number' => 'required|unique:orders',
            'order_date' => 'required|date',
            'country_id' => 'required|exists:countries,id',
            'service_type' => [
                'required',
                Rule::in(ServiceType::toArray())
            ],
            'company_id' => 'required|exists:companies,id',
            'hotel_id' => 'required|exists:hotels,id',
            'hall_id' => 'required|exists:halls,id',
            'mpi_for_normal' => 'nullable|exists:meal_prices,id',
            'mpi_for_ramadan' => 'nullable|exists:meal_prices,id',
            'order_note' => 'nullable',
            'status' => 'required',
            'meal_system_price_id' => 'required|array',
            'guest' => 'required|array',
            'from_date' => 'required|array',
            'to_date' => 'required|array',
        ];
    }
}
