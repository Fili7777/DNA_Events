<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\EventResource;
use App\Repositories\EventRepository;
use App\Http\Requests\UpdateEventRequest;
use App\Http\Requests\StoreEventRequest;

class EventController extends Controller
{
    private EventRepository $eventRepository;

    public function __construct(EventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function index()
    {
        // Logic to retrieve and return all events with eager loading of ticket types
        return EventResource::collection($this->eventRepository->getAll(['ticketTypes']));
    }
    public function show(int $id)
    {
        // Logic to retrieve and return a specific event with eager loading of ticket types
        return new EventResource($this->eventRepository->getById($id, ['ticketTypes']));
    }
    public function store(StoreEventRequest $request)
    {
        // Logic to create a new event
        $event = $this->eventRepository->create($request->validated());

        return new EventResource($event)->response()->setStatusCode(201);
    }
    public function update(UpdateEventRequest $request, int $id)
    {
        // Logic to update an existing event
        $event = $this->eventRepository->update($id, $request->validated());
        return new EventResource($event);
    }
    public function destroy(int $id)
    {
        // Logic to delete an event
        $this->eventRepository->delete($id);
        return response()->json([
            'message' => 'Event deleted successfully'
        ]);
    }
}
