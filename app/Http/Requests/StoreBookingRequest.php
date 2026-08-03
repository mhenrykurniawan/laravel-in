<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [

            'room_id' => 'required|exists:rooms,id',

            'booking_date' => 'required|date',

            'start_time' => 'required',

            'end_time' => 'required|after:start_time',

            'purpose' => 'required|min:10'

        ];
    }
}
