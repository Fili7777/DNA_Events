<?php

namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(EventSeeder::class); // popola sia con eventi che ticket types
        $this->call(UserSeeder::class); // popola con utenti
        $this->call(TicketSeeder::class); // popola con biglietti
    }
}
