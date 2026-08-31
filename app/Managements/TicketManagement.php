<?php

namespace App\Managements;

use App\Models\User;
use App\Repositories\TicketRepository;
use App\Repositories\TicketTypeRepository;
use Illuminate\Support\Facades\DB;

class TicketManagement
{
    public function __construct(
        private TicketRepository $ticketRepository,
        private TicketTypeRepository $ticketTypeRepository
    ) {}

    public function purchaseTicket(User $user, array $data)
    {
        return DB::transaction(function () use ($user, $data) {

            $ticketType = $this->ticketTypeRepository->getByIdForUpdate(
                $data['ticket_type_id']
            );

            if ($ticketType->quantity <= 0) {
                throw new \Exception('No tickets available.');
            }

            $ticket = $this->ticketRepository->create([
                'user_id' => $user->id,
                'ticket_type_id' => $ticketType->id,
                'attendee_name' => $data['attendee_name'],
                'attendee_surname' => $data['attendee_surname'],
                'attendee_birth_date' => $data['attendee_birth_date'],
                'attendee_phone' => $data['attendee_phone'],
            ]);

            $ticketType->decrement('quantity');

            return $ticket;
        });
    }
}