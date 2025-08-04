<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User; // Assuming your User model is here
use App\Models\Pengguna; // Or whatever your user model is named
use App\Models\Pengacara;
use App\Models\Riwayat;
use App\Models\Pesan;

class ConsultationRoomTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_authenticated_user_can_view_their_consultation_room(): void
    {
        // 1. ARRANGE
        // Create a user, a lawyer, and a consultation history record linking them.
        $user = Pengguna::factory()->create();
        $lawyer = Pengacara::factory()->create();

        $consultation = Riwayat::factory()->create([
            'nik_pengguna' => $user->nik_pengguna,
            'nik_pengacara' => $lawyer->nik_pengacara,
        ]);

        // Create a sample message for this consultation
        $message = Pesan::factory()->create([
            'id_riwayat' => $consultation->id,
            'nik' => $user->nik_pengguna,
            'teks' => 'Halo, ini pesan pertama saya.',
        ]);

        // 2. ACT
        // Log in as the user and visit the consultation room page.
        // Replace 'consultation.room' with your actual route name if it's different.
        $response = $this->actingAs($user, 'web')->get(route('consultation.client', ['id' => $consultation->id]));

        // 3. ASSERT
        // Check that the response is successful (status 200 OK)
        $response->assertStatus(200);

        // Check that we can see the main title and the lawyer's name
        $response->assertSee('Ruang Konsultasi');
        $response->assertSee($lawyer->nama_pengacara);

        // Check that we can see the chat message
        $response->assertSee($message->teks);
    }

    /** @test */
    public function a_guest_cannot_view_a_consultation_room(): void
    {
        // ARRANGE: Create a consultation room, but don't log anyone in.
        $consultation = Riwayat::factory()->create();

        // ACT: Try to visit the page as a guest.
        $response = $this->get(route('consultation.client', ['id' => $consultation->id]));

        // ASSERT: The user should be redirected to the login page.
        $response->assertRedirect('/masuk/pengguna'); // Or your login route
    }
}