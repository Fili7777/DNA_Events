<?php

namespace Database\Factories;

use App\Models\TicketType;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Event;

/**
 * @extends Factory<TicketType>
 */
class TicketTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' =>  'Normale',
            'price' => fake()->randomFloat(2, 10, 100),
            'quantity' => fake()->numberBetween(1, 100),
            'event_id' => Event::factory(), 
            //permette di creare un nuovo evento per ogni tipo di biglietto e associarlo automaticamente all'id dell'evento appena creato.
        ];
    }
}
