<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

#[Fillable(['name', 'description', 'start_time', 'location'])]
class Event extends Model
{
    use HasFactory;
    public function ticketTypes()
    {
        return $this->hasMany(TicketType::class);
    }

}