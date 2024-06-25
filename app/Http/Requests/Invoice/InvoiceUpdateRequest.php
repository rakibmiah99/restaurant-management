<?php

namespace App\Http\Requests\Invoice;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceUpdateRequest extends FormRequest
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
            'invoice_date' => 'required|date',
            'discount' => 'required|numeric',
            'meal_system_id' => 'required|array',
            'meal_system_id.*' => 'required|exists:meal_systems,id',
            'price' => 'required|array',
            'price.*' => 'required|numeric',
        ];
    }
}
