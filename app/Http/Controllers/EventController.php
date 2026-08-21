<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\EventResource;
use App\Models\Event;

class EventController extends Controller
{
    public function index()
    {
        // Logic to retrieve and return all events with eager loading of ticket types
        return EventResource::collection(Event::with('ticketTypes')->get());
    }
    public function show(int $id)
    {
        // Logic to retrieve and return a specific event with eager loading of ticket types
        return new EventResource(Event::with('ticketTypes')->findOrFail($id));
    }
    public function store(Request $request)
    {
        // Logic to create a new event
        $event = Event::create($request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'required|date',
            'location' => 'required|string|max:255',
        ]));
        return new EventResource($event)->response()->setStatusCode(201);
    }
    public function update(Request $request, int $id)
    {
        // Logic to update an existing event
        $event = Event::findOrFail($id);
        $event->update($request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',        
            'start_time' => 'sometimes|required|date',
            'location' => 'sometimes|required|string|max:255',
        ]));
        return new EventResource($event);
    }
    public function destroy(int $id)
    {
        // Logic to delete an event
        $event = Event::findOrFail($id);
        $event->delete();
        return response()->json([
            'message' => 'Event deleted successfully'
        ]);
    }
}
