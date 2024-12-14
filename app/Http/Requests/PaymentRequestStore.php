<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequestStore extends FormRequest
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

            'ticket_id' => 'required|string',

            'amount' => 'required|numeric|min:1000',

            'user_id' => 'required|exists:users,id',

            '$reservation_id' => 'nullable|exists:reservations,id',

            'payerIdentity' => 'required|string|email',

            'payerName' => 'required|string',

            'description' => 'required|string',
        ];
    }
    public function messages()
    {
        return [
            'ticket_id.required' => 'The order ID is required.',
            'amount.numeric' => 'The amount must be a valid number.',
            'amount.min' => 'The amount must be at least 1000 IRR.',
            'user_id.required' => 'The user ID is required.',
            'payerIdentity.required' => 'The payer email is required.',
            'payerIdentity.email' => 'The payer email format must be valid.',
            'payerName.required' => 'The payer name is required.',
            'description.required' => 'The payment description is required.',
            'reservation_id.required' => 'The payment reservation_id is required.',
        ];
    }
}
