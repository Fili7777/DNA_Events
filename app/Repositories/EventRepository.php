<?php

namespace App\Repositories;

use App\Models\Event;

class EventRepository
{
    public function getAll(array $relations = [])
    {
        return Event::with($relations)->get();
    }

    public function getById(int $id, array $relations = [])
    {
        return Event::with($relations)->findOrFail($id);
    }
    public function create(array $data)
    {
        return Event::create($data);
    }
    public function update(int $id, array $data)
    {
        $event = Event::findOrFail($id);
        $event->update($data);
        return $event;
    }
    public function delete(int $id)
    {
        return Event::findOrFail($id)->delete();
    }
}