<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\TicketType;

class EventSeeder extends Seeder
{
    public function run(): void
    {
    $events = Event::factory()->count(10)->create();

        foreach ($events as $event) {
            TicketType::factory()->create([
                'event_id' => $event->id,
            ]);

            TicketType::factory()->create([
                'type' => 'Vip',
                'event_id' => $event->id,
            ]);
        }
    }
}
