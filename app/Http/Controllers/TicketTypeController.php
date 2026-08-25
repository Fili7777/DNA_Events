<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\TicketTypeResource;
use App\Repositories\TicketTypeRepository;

class TicketTypeController extends Controller
{
    private TicketTypeRepository $ticketTypeRepository;

    public function __construct(TicketTypeRepository $ticketTypeRepository)
    {
        $this->ticketTypeRepository = $ticketTypeRepository;
    }

    public function index()
    {
        return TicketTypeResource::collection($this->ticketTypeRepository->getAll(['event']));
    }

    public function show(int $id)
    {
        return new TicketTypeResource($this->ticketTypeRepository->getById($id, ['event']));
    }

    public function store(Request $request)
    {
        $ticketType = $this->ticketTypeRepository->create($request->validate([
            'type' => 'required|string|max:255',
            'price' => 'required|numeric',
            'event_id' => 'required|exists:events,id',
            'quantity' => 'required|integer|min:1',
        ]));

       return (new TicketTypeResource($ticketType))
               ->response()
               ->setStatusCode(201);
    }

    public function update(Request $request, int $id)
    {
        $ticketType = $this->ticketTypeRepository->update($id, $request->validate([
            'type' => 'sometimes|required|string|max:255',
            'price' => 'sometimes|required|numeric',
            'event_id' => 'sometimes|required|exists:events,id',
            'quantity' => 'sometimes|required|integer|min:1',
        ]));

        return new TicketTypeResource($ticketType);
    }

    public function destroy(int $id)
    {
        $this->ticketTypeRepository->delete($id);

        return response()->json([
            'message' => 'Ticket type deleted successfully'
        ]);
    }
}
