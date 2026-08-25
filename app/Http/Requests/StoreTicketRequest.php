<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'attendee_name' => 'required|string|max:255',
            'attendee_surname' => 'required|string|max:255',
            'attendee_birth_date' => 'required|date',
            'attendee_phone' => 'required|string|max:20',
            'ticket_type_id' => 'required|integer|exists:ticket_types,id',
            'user_id' => 'required|integer|exists:users,id',
        ];
    }
}
