<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\TicketType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SimpleApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_events_endpoint_returns_data()
    {
        // Create an event with a ticket type
        $event = Event::create([
            'name' => 'Test Event',
            'description' => 'A test event',
            'start_time' => now()->addDay(),
            'location' => 'Test Location',
        ]);

        TicketType::create([
            'type' => 'VIP',
            'price' => 100.00,
            'event_id' => $event->id,
            'quantity' => 50,
        ]);

        // Call the API
        $response = $this->getJson('/api/events');

        // Should be successful
        $response->assertOk();

        // Should have data wrapper with at least one event
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'description',
                    'start_time',
                    'location',
                    'ticket_types' => [
                        '*' => [
                            'id',
                            'type',
                            'price',
                            'quantity'
                        ]
                    ]
                ]
            ]
        ]);

        // Should have exactly one event
        $response->assertJsonCount(1, 'data');

        // Check event data
        $eventData = $response->json('data')[0];
        $this->assertEquals($event->id, $eventData['id']);
        $this->assertEquals('Test Event', $eventData['name']);
        $this->assertEquals('A test event', $eventData['description']);

        // Check ticket type data
        $ticketType = $eventData['ticket_types'][0];
        $this->assertEquals('VIP', $ticketType['type']);
        $this->assertEquals(100.00, $ticketType['price']);
        $this->assertEquals(50, $ticketType['quantity']);
    }
}