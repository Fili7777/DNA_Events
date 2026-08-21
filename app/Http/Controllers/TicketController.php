<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Http\Resources\TicketResource;
use \App\Models\Ticket;
class TicketController extends Controller
{
    public function index()
    {
         
        return TicketResource::collection(Ticket::with('ticketType', 'user')->get());
    }
    public function show(int $id)
    {
        $ticket = Ticket::with('ticketType', 'user')->findOrFail($id);
        return new TicketResource($ticket);
    }
    public function store(Request $request)
    {
    $ticket = Ticket::create($request->validate([
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
        $ticket = Ticket::findOrFail($id);
        $ticket->update($request->validate([
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
        $ticket = Ticket::findOrFail($id);
        $ticket->delete();
        return response()->json([
            'message' => 'Ticket deleted'
        ]);
    }

}
