<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Kamus;
use App\Models\Pengguna; // Pastikan model Pengguna di-import

class KamusTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_display_the_dictionary_page_for_guests_and_shows_all_terms()
    {
        // 1. Arrange: Buat data kamus
        Kamus::factory()->create(['istilah' => 'Gugatan', 'arti_istilah' => 'Arti dari gugatan.']);
        Kamus::factory()->create(['istilah' => 'Banding', 'arti_istilah' => 'Arti dari banding.']);

        // 2. Act: Akses halaman kamus sebagai tamu (guest)
        $response = $this->get(route('kamus'));

        // 3. Assert: Pastikan halaman berhasil diakses dan menampilkan data yang benar
        $response->assertStatus(200);
        $response->assertViewIs('kamus_sebelum'); // Pastikan view untuk guest yang dimuat
        $response->assertSee('CARI ISTILAH HUKUM');
        $response->assertSee('Gugatan');
        $response->assertSee('Banding');
    }

    /** @test */
    public function it_can_display_the_dictionary_page_for_authenticated_users()
    {
        // 1. Arrange: Buat user dan login
        $user = Pengguna::factory()->create();
        $this->actingAs($user);

        // 2. Act: Akses halaman kamus
        $response = $this->get(route('kamus'));

        // 3. Assert: Pastikan halaman berhasil diakses dan view untuk user login yang dimuat
        $response->assertStatus(200);
        $response->assertViewIs('user.kamus_setelah'); // Pastikan view untuk user yang sudah login dimuat
    }

    public function it_can_search_for_a_term_and_display_results()
    {
        // 1. Arrange: Buat data yang relevan dan tidak relevan
        Kamus::factory()->create(['istilah' => 'Advokat']);
        Kamus::factory()->create(['istilah' => 'Mediasi']);

        // 2. Act: Lakukan pencarian
        $response = $this->get(route('kamus', ['q' => 'Advokat']));

        // 3. Assert: Gunakan assertSeeText untuk hasil yang paling akurat
        $response->assertStatus(200);
        $response->assertSeeText('Hasil Pencarian untuk "Advokat"');
        $response->assertSeeText('Advokat');
        $response->assertDontSeeText('Mediasi');
    }

    /** @test */
    public function it_shows_a_message_when_search_yields_no_results()
    {
        // 1. Arrange: Buat data dummy
        Kamus::factory()->create(['istilah' => 'Hukum Perdata']);

        // 2. Act: Lakukan pencarian dengan keyword yang tidak ada
        $response = $this->get(route('kamus', ['q' => 'TidakAkanDitemukan']));

        // 3. Assert: Pastikan pesan "tidak ditemukan" muncul
        $response->assertStatus(200);
        $response->assertSee('Tidak ditemukan hasil untuk pencarian ini.');
        $response->assertDontSee('Hukum Perdata');
    }

    /** @test */
    public function it_can_filter_terms_by_letter()
    {
        // 1. Arrange: Buat data dengan huruf awal yang berbeda
        Kamus::factory()->create(['istilah' => 'Kasasi']);
        Kamus::factory()->create(['istilah' => 'Banding']);
        Kamus::factory()->create(['istilah' => 'Borgtocht']); // istilah lain berawalan B

        // 2. Act: Filter berdasarkan huruf 'B'
        $response = $this->get(route('kamus', ['letter' => 'B']));

        // 3. Assert: Pastikan hanya istilah berawalan 'B' yang muncul
        $response->assertStatus(200);
        $response->assertSee('<div class="huruf-terpilih">B</div>', false); // Cek HTML mentah
        $response->assertSee('Banding');
        $response->assertSee('Borgtocht');
        $response->assertDontSee('Kasasi');
    }

    /** @test */
    public function it_shows_a_message_when_letter_filter_yields_no_results()
    {
        // 1. Arrange: Buat data dengan huruf awal 'A'
        Kamus::factory()->create(['istilah' => 'Arbitrase']);

        // 2. Act: Filter berdasarkan huruf 'Z' yang tidak memiliki entri
        $response = $this->get(route('kamus', ['letter' => 'Z']));

        // 3. Assert: Pastikan pesan "tidak ditemukan" muncul
        $response->assertStatus(200);
        $response->assertSee('Tidak ditemukan hasil untuk pencarian ini.');
        $response->assertDontSee('Arbitrase');
    }

    /** @test */
    public function it_paginates_results_correctly()
    {
        // 1. Arrange: Buat 25 data (controller paginate(20))
        Kamus::factory()->count(25)->create();

        // 2. Act: Akses halaman pertama
        $response = $this->get(route('kamus'));

        // 3. Assert: Pastikan hanya 20 data yang muncul di halaman pertama
        $response->assertStatus(200);
        $response->assertViewHas('kamus', function ($kamus) {
            return $kamus->count() === 20;
        });

        // Act & Assert untuk halaman kedua
        $responsePage2 = $this->get(route('kamus', ['page' => 2]));
        $responsePage2->assertStatus(200);
        $responsePage2->assertViewHas('kamus', function ($kamus) {
            return $kamus->count() === 5;
        });
    }

    /** @test */
    public function it_persists_letter_filter_during_pagination()
    {
        // 1. Arrange: Buat 25 data dengan awalan 'P' untuk memaksa paginasi
        Kamus::factory()->count(25)->sequence(fn($sequence) => ['istilah' => 'Perdata ' . $sequence->index])->create();

        // 2. Act: Akses halaman pertama dengan filter huruf 'P'
        $response = $this->get(route('kamus', ['letter' => 'P']));

        // 3. Assert: Pastikan link ke halaman 2 mengandung query '?letter=P&page=2'
        // Di dalam HTML, ini akan ditulis sebagai '&amp;page=2'
        $response->assertStatus(200);

        // String yang kita cari di dalam atribut href="..."
        $expected_link_fragment = '?letter=P&amp;page=2';

        // Gunakan parameter kedua 'false' untuk memberitahu assertSee
        // agar tidak melakukan escaping pada string kita.
        $response->assertSee($expected_link_fragment, false);
    }

    /** @test */
    public function it_displays_all_required_assets_and_links()
    {
        // 1. Arrange: -

        // 2. Act: Akses halaman kamus
        $response = $this->get(route('kamus'));

        // 3. Assert: Pastikan semua aset dan link penting ada di halaman
        $response->assertStatus(200);
        $response->assertSee(asset('assets/styles/kamus.css'), false);
        $response->assertSee(asset('assets/images/search-kamus.png'), false);
        $response->assertSee(asset('assets/scripts/kamus-modal.js'), false);

        // Cek link untuk setiap huruf
        foreach (range('A', 'Z') as $char) {
            $response->assertSee(route('kamus', ['letter' => $char]), false);
        }
    }
    /** @test */
    public function it_has_correct_attributes_for_modal_popup_on_each_term()
    {
        // 1. Arrange: Buat sebuah data kamus yang spesifik
        $kamusEntry = Kamus::factory()->create([
            'istilah' => 'Gugatan',
            'arti_istilah' => 'Ini adalah arti dari gugatan hukum.',
        ]);

        // 2. Act: Akses halaman kamus
        $response = $this->get(route('kamus'));
        $response->assertStatus(200);

        // 3. Assert: Pastikan setiap atribut penting ada di dalam HTML
        // Kita pecah pengecekan menjadi beberapa bagian agar lebih kuat
        // terhadap perubahan whitespace (spasi/baris baru).

        // Gunakan e() untuk memastikan kita membandingkan dengan nilai yang sudah di-escape.
        $escapedIstilah = e($kamusEntry->istilah);
        $escapedArti = e($kamusEntry->arti_istilah);

        // Cek satu per satu atribut yang paling krusial.
        $response->assertSee('data-bs-toggle="modal"', false);
        $response->assertSee('data-bs-target="#kamusModal"', false);
        $response->assertSee("data-istilah=\"{$escapedIstilah}\"", false);
        $response->assertSee("data-arti=\"{$escapedArti}\"", false);
    }
}
