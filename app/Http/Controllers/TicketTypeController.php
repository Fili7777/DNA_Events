<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TicketType;
use App\Http\Resources\TicketTypeResource;
class TicketTypeController extends Controller
{
    public function index()
    {
        return TicketTypeResource::collection(TicketType::with('event')->get());
    }
    public function show(int $id)
    {
        $ticketType = TicketType::with('event')->findOrFail($id);
        return new TicketTypeResource($ticketType);
    }
    public function store(Request $request)
    {
        $ticketType = TicketType::create($request->validate([
            'type' => 'required|string|max:255',
            'price' => 'required|numeric',
            'event_id' => 'required|exists:events,id',
            'quantity' => 'required|integer|min:1',
        ]));

       return (new TicketTypeResource($ticketType))
               ->response()
               ->setStatusCode(201);
    }
    public function update(Request $request, int $id){

        $ticketType = TicketType::findOrFail($id);
        $ticketType->update($request->validate([
            'type' => 'sometimes|required|string|max:255',
            'price' => 'sometimes|required|numeric',
            'event_id' => 'sometimes|required|exists:events,id',
            'quantity' => 'sometimes|required|integer|min:1',
        ]));
        return new TicketTypeResource($ticketType);
    }
    public function destroy(int $id)
    {
        $ticketType = TicketType::findOrFail($id);
        $ticketType->delete();
        return response()->json([
            'message' => 'Ticket type deleted successfully'
        ]);
    }

}
