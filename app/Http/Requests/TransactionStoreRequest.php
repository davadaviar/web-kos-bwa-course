<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionStoreRequest extends FormRequest
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

            'code' => 'required|integer',
            'boarding_house_id' => 'required|exists:boarding_houses,id',
            'room_id' => 'required|exists:rooms,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|string|max:15',
            'payment_method' => 'nullable|in:down_payment,full_payment',
            'payment_status' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'duration' => 'required|integer|min:1',
            'total_amount' => 'nullable|integer|min:0',
            'transaction_date' => 'nullable|date',

        ];
    }
}
