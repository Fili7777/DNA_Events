<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use App\Models\Ticket;
use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\HasFactory;

#[Fillable(['type', 'price', 'event_id','quantity'])]

class TicketType extends Model
{
    use HasFactory;
    public function event(){
        return $this->belongsTo(Event::class);
    }
    public function tickets(){
        return $this->hasMany(Ticket::class);
    }

}
