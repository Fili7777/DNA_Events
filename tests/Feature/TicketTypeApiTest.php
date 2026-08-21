<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\TicketType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TicketTypeApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_ticket_types_endpoint_returns_resources()
    {
        // Create an event
        $event = Event::create([
            'name' => 'Test Event',
            'description' => 'A test event',
            'start_time' => now()->addDay(),
            'location' => 'Test Location',
        ]);

        // Create ticket types
        $ticketType1 = TicketType::create([
            'type' => 'General',
            'price' => 30.00,
            'event_id' => $event->id,
            'quantity' => 100,
        ]);

        $ticketType2 = TicketType::create([
            'type' => 'VIP',
            'price' => 80.00,
            'event_id' => $event->id,
            'quantity' => 50,
        ]);

        // Call API
        $response = $this->getJson('/api/ticket-types');

        // Should be successful
        $response->assertOk();

        // Should have data wrapper with ticket types
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'type',
                    'price',
                    'quantity',
                    'event' => [
                        'id',
                        'name',
                        'description',
                        'start_time',
                        'location'
                    ]
                ]
            ]
        ]);

        // Should have exactly 2 ticket types
        $response->assertJsonCount(2, 'data');

        // Check first ticket type
        $data = $response->json('data');
        $tt1 = $data[0];
        $this->assertEquals($ticketType1->id, $tt1['id']);
        $this->assertEquals('General', $tt1['type']);
        $this->assertEquals(30.00, $tt1['price']);
        $this->assertEquals(100, $tt1['quantity']);
        // Check nested event
        $this->assertEquals($event->id, $tt1['event']['id']);
        $this->assertEquals('Test Event', $tt1['event']['name']);

        // Check second ticket type
        $tt2 = $data[1];
        $this->assertEquals($ticketType2->id, $tt2['id']);
        $this->assertEquals('VIP', $tt2['type']);
        $this->assertEquals(80.00, $tt2['price']);
        $this->assertEquals(50, $tt2['quantity']);
        $this->assertEquals($event->id, $tt2['event']['id']);
    }

    public function test_ticket_type_show_returns_single_resource()
    {
        // Create an event
        $event = Event::create([
            'name' => 'Test Event',
            'description' => 'A test event',
            'start_time' => now()->addDay(),
            'location' => 'Test Location',
        ]);

        // Create ticket type
        $ticketType = TicketType::create([
            'type' => 'Premium',
            'price' => 120.00,
            'event_id' => $event->id,
            'quantity' => 25,
        ]);

        // Call API for single ticket type
        $response = $this->getJson("/api/ticket-types/{$ticketType->id}");

        // Should be successful
        $response->assertOk();

        // Should have data wrapper with single ticket type
        $response->assertJsonStructure([
            'data' => [
                'id',
                'type',
                'price',
                'quantity',
                'event' => [
                    'id',
                    'name',
                    'description',
                    'start_time',
                    'location'
                ]
            ]
        ]);

        $data = $response->json('data');
        $this->assertEquals($ticketType->id, $data['id']);
        $this->assertEquals('Premium', $data['type']);
        $this->assertEquals(120.00, $data['price']);
        $this->assertEquals(25, $data['quantity']);
        $this->assertEquals($event->id, $data['event']['id']);
    }
}