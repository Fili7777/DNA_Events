<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTicketRequest extends FormRequest
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
            'attendee_name' => 'sometimes|required|string|max:255',
            'attendee_surname' => 'sometimes|required|string|max:255',
            'attendee_birth_date' => 'sometimes|required|date',
            'attendee_phone' => 'sometimes|required|string|max:20',
            'ticket_type_id' => 'sometimes|required|integer|exists:ticket_types,id',
            'user_id' => 'sometimes|required|integer|exists:users,id',
        ];
    }
}
