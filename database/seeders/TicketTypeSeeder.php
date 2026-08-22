<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Models\TicketType;

class TicketTypeSeeder extends Seeder
{
   
    //USARE SOLO SE SI VUOLE CREARE ANCHE EVENTO NUOVO A OGNI TicketType, ALTRIMENTI CHIAMARE EVENT SEEDER CHE FA TUTTO INSIEME.
    public function run(): void
    {
        TicketType::factory()->count(10)->create();
    }
}
