<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\TicketResource;
use App\Repositories\TicketRepository;

class TicketController extends Controller
{
    private TicketRepository $ticketRepository;

    public function __construct(TicketRepository $ticketRepository)
    {
        $this->ticketRepository = $ticketRepository;
    }

    public function index()
    {
        return TicketResource::collection($this->ticketRepository->getAll(['ticketType', 'user']));
    }

    public function show(int $id)
    {
        return new TicketResource($this->ticketRepository->getById($id, ['ticketType', 'user']));
    }

    public function store(Request $request)
    {
        $ticket = $this->ticketRepository->create($request->validate([
            'attendee_name' => 'required|string|max:255',
            'attendee_surname' => 'required|string|max:255',
            'attendee_birth_date' => 'required|date',
            'attendee_phone' => 'required|string|max:20',
            'ticket_type_id' => 'required|integer|exists:ticket_types,id',
            'user_id' => 'required|integer|exists:users,id',
        ]));

        return new TicketResource($ticket)->response()->setStatusCode(201);
    }

    public function update(Request $request, int $id)
    {
        $ticket = $this->ticketRepository->update($id, $request->validate([
            'attendee_name' => 'sometimes|required|string|max:255',
            'attendee_surname' => 'sometimes|required|string|max:255',
            'attendee_birth_date' => 'sometimes|required|date',
            'attendee_phone' => 'sometimes|required|string|max:20',
            'ticket_type_id' => 'sometimes|required|integer|exists:ticket_types,id',
            'user_id' => 'sometimes|required|integer|exists:users,id',
        ]));

        return new TicketResource($ticket);
    }

    public function destroy(int $id)
    {
        $this->ticketRepository->delete($id);

        return response()->json([
            'message' => 'Ticket deleted'
        ]);
    }
}
