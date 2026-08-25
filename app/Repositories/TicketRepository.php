<?php

namespace App\Repositories;

use App\Models\Ticket;

class TicketRepository
{
    public function getAll(array $relations = [])
    {
        return Ticket::with($relations)->get();
    }

    public function getById(int $id, array $relations = [])
    {
        return Ticket::with($relations)->findOrFail($id);
    }

    public function create(array $data)
    {
        return Ticket::create($data);
    }

    public function update(int $id, array $data)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->update($data);

        return $ticket;
    }

    public function delete(int $id)
    {
        return Ticket::findOrFail($id)->delete();
    }
}
