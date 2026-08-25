<?php

namespace App\Http\Controllers;

use App\Http\Resources\TicketResource;
use App\Repositories\TicketRepository;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
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

    public function store(StoreTicketRequest $request)
    {
        $ticket = $this->ticketRepository->create($request->validated());

        return new TicketResource($ticket)->response()->setStatusCode(201);
    }

    public function update(UpdateTicketRequest $request, int $id)
    {
        $ticket = $this->ticketRepository->update($id, $request->validated());

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
