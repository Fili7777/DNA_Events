<?php

namespace App\Repositories;

use App\Models\TicketType;

class TicketTypeRepository
{
    public function getAll(array $relations = [])
    {
        return TicketType::with($relations)->get();
    }

    public function getById(int $id, array $relations = [])
    {
        return TicketType::with($relations)->findOrFail($id);
    }
    
    public function getByIdForUpdate(int $id, array $relations = [])
    {
        return TicketType::with($relations)->lockForUpdate()->findOrFail($id);
    }

    public function create(array $data)
    {
        return TicketType::create($data);
    }

    public function update(int $id, array $data)
    {
        $ticketType = TicketType::findOrFail($id);
        $ticketType->update($data);

        return $ticketType;
    }

    public function delete(int $id)
    {
        return TicketType::findOrFail($id)->delete();
    }
}
