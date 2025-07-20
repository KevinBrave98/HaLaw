<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ConsultationRoomTest extends TestCase
{
    public function test_client_can_see_the_consultation_room(): void
    {
        $response = $this->get(route('consultation.client'));

        $response->assertStatus(200);
        $response->assertSee('Nama Pengacara');
        $response->assertSee('Sisa Waktu');
        $response->assertSee('Type a Message');
        $response->assertSeeText('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod');
    }
    public function test_lawyer_can_see_the_consultation_room(): void
    {
        $response = $this->get(route('consultation.lawyer'));

        $response->assertStatus(200);
        $response->assertSee('Nama Klien');
        $response->assertSee('Sisa Waktu');
        $response->assertSee('Type a Message');
        $response->assertSeeText('Lorem ipsum dolor sit amet.');
    }
    public function test_client_view_displays_messages_correctly(): void
    {
        $response = $this->get(route('consultation.client'));

        $response->assertSeeInOrder([
            'Lawyer', // Name of the sender
            'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod', // Received message
            'Lorem ipsum dolor sit amet.', // Sent message
        ]);
    }
    public function test_lawyer_view_displays_messages_correctly(): void
    {
        $response = $this->get(route('consultation.lawyer'));

        $response->assertSeeInOrder([
            'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod', // Sent message
            'Klien', // Name of the sender
            'Lorem ipsum dolor sit amet.', // Received message
        ]);
    }
}