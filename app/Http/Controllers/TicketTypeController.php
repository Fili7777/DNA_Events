<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\TicketTypeResource;
use App\Repositories\TicketTypeRepository;
use App\Http\Requests\StoreTicketTypeRequest;
use App\Http\Requests\UpdateTicketTypeRequest;

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

    public function store(StoreTicketTypeRequest $request)
    {
        $ticketType = $this->ticketTypeRepository->create($request->validated());

       return (new TicketTypeResource($ticketType))
               ->response()
               ->setStatusCode(201);
    }

    public function update(UpdateTicketTypeRequest $request, int $id)
    {
        $ticketType = $this->ticketTypeRepository->update($id, $request->validated());

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
