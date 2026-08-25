<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ticket;
use App\Models\TicketType;
use App\Models\User;
use App\Models\Event;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $events = Event::with('ticketTypes')->get(); 

        foreach ($users as $user) {
            $numberOfTickets = rand(1, 2); // Numero casuale di biglietti da creare per l'utente
            while($numberOfTickets > 0) {
  
                $event = $events->random();
                $ticketTypes = $event->ticketTypes->where('quantity', '>', 0);  //where sulla collection per filtrare i tipi di biglietti con quantità maggiore di 0 altrimenti restituisce una collection vuota

                if ($ticketTypes->isNotEmpty()) { // Controlla se la collection non è vuota
                $ticketType = $ticketTypes->random(); // Seleziona un tipo di biglietto casuale tra quelli disponibili

                    // Crea un biglietto per l'utente e il tipo di biglietto selezionato
                    Ticket::factory()->create([
                        'user_id' => $user->id,
                        'ticket_type_id' => $ticketType->id,
                    ]);

                    // Riduci la quantità disponibile del tipo di biglietto
                    $ticketType->decrement('quantity');
                    $numberOfTickets--;
                }
                
            }
            
          
        }
    }
}
