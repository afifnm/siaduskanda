<?php

namespace Tests\Feature;

use App\Models\Pengaduan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PengaduanLifecycleTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_is_accessible_and_displays_stats(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('SIADU');
        $response->assertSee('SMK Negeri 2 Karanganyar');
    }

    public function test_public_user_can_submit_complaint_successfully(): void
    {
        $payload = [
            'kategori' => 'Sarana dan prasarana',
            'jenis_pelapor' => 'Siswa',
            'nama_pelapor' => 'Andi Wijaya',
            'kontak' => '081234567890',
            'judul' => 'Kursi Patah di Ruang Kelas 10 RPL',
            'lokasi' => 'Ruang Teori 10 RPL Lantai 2',
            'uraian' => 'Terdapat dua kursi kayu yang patah pada bagian sandaran dan berisiko melukai siswa.',
            'urgensi_pelapor' => 'Normal',
        ];

        $response = $this->post('/pengaduan', $payload);

        $this->assertDatabaseHas('pengaduans', [
            'judul' => 'Kursi Patah di Ruang Kelas 10 RPL',
            'kategori' => 'Sarana dan prasarana',
            'status' => 'masuk',
            'nama_pelapor' => 'Andi Wijaya',
        ]);

        $pengaduan = Pengaduan::where('judul', 'Kursi Patah di Ruang Kelas 10 RPL')->first();
        $this->assertNotNull($pengaduan);
        $this->assertStringStartsWith('TKT-', $pengaduan->ticket_number);

        $response->assertRedirect(route('pengaduan.track', ['ticket' => $pengaduan->ticket_number]));
    }

    public function test_user_can_track_complaint_by_ticket_number(): void
    {
        $pengaduan = Pengaduan::create([
            'ticket_number' => 'TKT-2026-9999',
            'kategori' => 'Sarana dan prasarana',
            'jenis_pelapor' => 'Siswa',
            'nama_pelapor' => 'Budi Pratama',
            'judul' => 'Pintu Kamar Mandi Rusak',
            'uraian' => 'Kunci pintu toilet siswa rusak dan tidak bisa ditutup dari dalam.',
            'urgensi_pelapor' => 'Normal',
            'status' => 'masuk',
            'tanggal_lapor' => now(),
        ]);

        $response = $this->get(route('pengaduan.track', ['ticket' => 'TKT-2026-9999']));

        $response->assertStatus(200);
        $response->assertSee('TKT-2026-9999');
        $response->assertSee('Pintu Kamar Mandi Rusak');
    }

    public function test_full_lifecycle_from_submission_to_closure_and_rating(): void
    {
        $admin = User::factory()->create([
            'name' => 'Admin Test',
            'email' => 'admin.test@smkn2kra.sch.id',
            'role' => 'admin',
        ]);

        // 1. Submit complaint
        $pengaduan = Pengaduan::create([
            'ticket_number' => 'TKT-2026-1001',
            'kategori' => 'Sarana dan prasarana',
            'jenis_pelapor' => 'Siswa',
            'nama_pelapor' => 'Budi Santoso',
            'judul' => 'Monitor Lab 1 Mati',
            'uraian' => 'Layar monitor PC 05 di Lab RPL 1 tidak menampilkan gambar.',
            'urgensi_pelapor' => 'Mendesak',
            'status' => 'masuk',
            'tanggal_lapor' => now(),
        ]);

        // 2. Admin assigns ticket to unit & technician PIC
        $assignResponse = $this->actingAs($admin)->post("/admin/pengaduan/{$pengaduan->id}/assign", [
            'kategori_definitif' => 'Sarana dan prasarana',
            'urgensi_admin' => 'Mendesak',
            'unit_tujuan' => 'Unit IT & Lab Komputer',
            'nama_petugas' => 'Pak Joko (Teknisi Lab)',
            'catatan_admin' => 'Periksa kabel power dan port VGA/HDMI.',
        ]);

        $assignResponse->assertRedirect(route('admin.dashboard'));
        $pengaduan->refresh();
        $this->assertEquals('terverifikasi', $pengaduan->status);
        $this->assertEquals('Pak Joko (Teknisi Lab)', $pengaduan->nama_petugas);

        // 3. Admin starts handling
        $startResponse = $this->actingAs($admin)->post("/petugas/pengaduan/{$pengaduan->id}/start");
        $startResponse->assertRedirect(route('admin.dashboard'));
        $pengaduan->refresh();
        $this->assertEquals('dalam_proses', $pengaduan->status);

        // 4. Admin submits resolution
        $resolveResponse = $this->actingAs($admin)->post("/petugas/pengaduan/{$pengaduan->id}/resolve", [
            'catatan_petugas' => 'Kabel adaptor diganti dengan unit baru dan monitor kembali menyala normal.',
            'suku_cadang' => '1x Adaptor 12V Monitor LG',
        ]);
        $resolveResponse->assertRedirect(route('admin.dashboard'));
        $pengaduan->refresh();
        $this->assertEquals('menunggu_konfirmasi', $pengaduan->status);

        // 5. Admin closes ticket
        $closeResponse = $this->actingAs($admin)->post("/admin/pengaduan/{$pengaduan->id}/close", [
            'admin_close_feedback' => 'Hasil perbaikan telah diverifikasi berfungsi baik di Lab 1.',
        ]);
        $closeResponse->assertRedirect(route('admin.dashboard'));
        $pengaduan->refresh();
        $this->assertEquals('selesai', $pengaduan->status);
        $this->assertNotNull($pengaduan->tanggal_selesai);

        // 6. Pelapor leaves rating feedback
        $feedbackResponse = $this->post("/pengaduan/{$pengaduan->id}/feedback", [
            'rating' => 5,
            'ulasan_pelapor' => 'Sangat cepat dan responsif, terima kasih!',
        ]);
        $pengaduan->refresh();
        $this->assertEquals(5, $pengaduan->rating);
        $this->assertEquals('Sangat cepat dan responsif, terima kasih!', $pengaduan->ulasan_pelapor);
    }

    public function test_public_user_without_login_can_view_complaints_history(): void
    {
        Pengaduan::create([
            'ticket_number' => 'TKT-2026-7771',
            'kategori' => 'Sarana dan prasarana',
            'jenis_pelapor' => 'Siswa',
            'nama_pelapor' => 'Dimas Anggara',
            'judul' => 'Kipas Angin Ruang Kelas Mati',
            'uraian' => 'Kipas angin di ruang kelas 11 mesin berdengung dan tidak berputar.',
            'urgensi_pelapor' => 'Normal',
            'status' => 'masuk',
            'tanggal_lapor' => now(),
        ]);

        $response = $this->get('/riwayat');

        $response->assertStatus(200);
        $response->assertSee('Riwayat Pengaduan');
        $response->assertSee('TKT-2026-7771');
        $response->assertSee('Kipas Angin Ruang Kelas Mati');
        $response->assertSee('Dimas Anggara');
    }

    public function test_public_user_can_filter_complaints_history_by_status_and_search(): void
    {
        Pengaduan::create([
            'ticket_number' => 'TKT-2026-8881',
            'kategori' => 'Pembelajaran dan akademik',
            'jenis_pelapor' => 'Guru',
            'nama_pelapor' => 'Pak Guru Budi',
            'judul' => 'Proyektor LCD Laboratorium Rusak',
            'uraian' => 'Lampu proyektor LCD di lab RPL berkedip merah dan mati.',
            'urgensi_pelapor' => 'Mendesak',
            'status' => 'selesai',
            'tanggal_lapor' => now()->subDay(),
        ]);

        Pengaduan::create([
            'ticket_number' => 'TKT-2026-8882',
            'kategori' => 'Sarana dan prasarana',
            'jenis_pelapor' => 'Siswa',
            'nama_pelapor' => 'Siswa Anonim',
            'is_anonim' => true,
            'judul' => 'Keran Wastafel Bocor Menggenang',
            'uraian' => 'Wastafel depan bengkel otomotif mengalir terus menerus.',
            'urgensi_pelapor' => 'Normal',
            'status' => 'masuk',
            'tanggal_lapor' => now(),
        ]);

        // Filter by status=selesai
        $filterResponse = $this->get('/riwayat?status=selesai');
        $filterResponse->assertStatus(200);
        $filterResponse->assertSee('TKT-2026-8881');
        $filterResponse->assertDontSee('TKT-2026-8882');

        // Search by keyword
        $searchResponse = $this->get('/riwayat?search=Wastafel');
        $searchResponse->assertStatus(200);
        $searchResponse->assertSee('TKT-2026-8882');
        $searchResponse->assertSee('Pelapor Anonim');
    }
}
