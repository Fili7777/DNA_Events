<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=> $this->id,
            'attendee_name' => $this->attendee_name,
            'attendee_surname' => $this->attendee_surname,
            'attendee_birth_date' => $this->attendee_birth_date,
            'attendee_phone' => $this->attendee_phone,
            'ticket_type' => new TicketTypeResource($this->whenLoaded('ticketType')), // Eager loaded ticket type, if any
            'user' => new UserResource($this->whenLoaded('user')), // Eager loaded user, if any
        ];
    }
}
