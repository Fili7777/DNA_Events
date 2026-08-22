<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\TicketType;

#[Fillable(['user_id', 'ticket_type_id', 'attendee_name', 'attendee_surname', 'attendee_birth_date', 'attendee_phone'])]
class Ticket extends Model
{
    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function ticketType(){
        return $this->belongsTo(TicketType::class);
    }
}
