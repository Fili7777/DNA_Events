<?php

namespace App\Http\Controllers;

use App\Http\Resources\TicketResource;
use App\Repositories\TicketRepository;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Http\Requests\PurchaseTicketRequest;
use App\Managements\TicketManagement;
use Illuminate\Http\Request;


class TicketController extends Controller
{
    private TicketRepository $ticketRepository;
    private TicketManagement $ticketManagement;


    public function __construct(TicketRepository $ticketRepository, TicketManagement $ticketManagement)
    {
        $this->ticketRepository = $ticketRepository;
        $this->ticketManagement = $ticketManagement;
    }

    public function index()
    {
        return TicketResource::collection($this->ticketRepository->getAll(['ticketType', 'user']));
    }
    public function myTickets(Request $request)
    {
        $tickets = $this->ticketRepository->getByUser($request->user(), ['ticketType', 'user']);
        return TicketResource::collection($tickets);
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

    public function purchase(PurchaseTicketRequest $request)
    {
        try{
            $ticket = $this->ticketManagement->purchaseTicket($request->user(), $request->validated());
        }
        catch(\Exception $e){
            return response()->json([
                'message' => 'No tickets available for this ticket type.'
            ], 409);
        }
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
