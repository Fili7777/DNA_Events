<?php

namespace Database\Factories;

use App\Models\Ticket;
use App\Models\TicketType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends Factory<Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'attendee_name' => fake()->firstName(),
            'attendee_surname' => fake()->lastName(),
            'attendee_birth_date' => fake()->dateTimeBetween('-80 years', '-18 years'),
            'attendee_phone' => fake()->phoneNumber(),
            'ticket_type_id' => TicketType::factory(),
            'user_id' => User::factory(),
        ];
    }
}
