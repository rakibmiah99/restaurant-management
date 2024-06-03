<?php

namespace App\Http\Requests\Hall;

use Illuminate\Foundation\Http\FormRequest;

class CreateHallRequest extends FormRequest
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
            'name' => 'required',
            'code' => 'required',
            'capacity' => 'required|numeric',
            'hotel_id' => '|exists:hotels,id',
            'b_start' => 'date_format:H:i',
            'b_end' => 'date_format:H:i|after:b_start',
            'l_start' => 'date_format:H:i|after:b_end',
            'l_end' => 'date_format:H:i|after:l_start',
            'd_start' => 'date_format:H:i|after:l_end',
            'd_end' => 'date_format:H:i|after:d_start',
            's_start' => 'date_format:H:i',
            's_end' => 'date_format:H:i|after:s_start',
            'i_start' => 'date_format:H:i|after:s_end',
            'i_end' => 'date_format:H:i|after:i_start',
        ];
    }
}
