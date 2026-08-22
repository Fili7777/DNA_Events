<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ticket;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = \App\Models\User::all();
        $events = \App\Models\Event::all();

        foreach ($users as $user) {
            $numberOfTickets = rand(1, 2); // Numero casuale di biglietti da creare per l'utente
            while($numberOfTickets > 0) {
                $event = $events->random(); // Seleziona un evento casuale
                $ticketType = $event->ticketTypes()->where('quantity','>',0)->inRandomOrder()->first(); // Seleziona un tipo di biglietto casuale per l'evento

                if ($ticketType) { // Controlla se esiste un tipo di biglietto disponibile
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
