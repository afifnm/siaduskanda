<?php

namespace Tests\Feature;

use App\Models\Pengaduan;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ImageUploadWebpTest extends TestCase
{
    use RefreshDatabase;

    public function test_uploaded_complaint_image_is_converted_to_webp(): void
    {
        Storage::fake('public');

        // Create a fake test JPG image (e.g. 1400x900 to test both conversion and auto-resizing)
        $file = UploadedFile::fake()->image('kerusakan_lab.jpg', 1400, 900);

        $payload = [
            'kategori' => 'Sarana dan prasarana',
            'jenis_pelapor' => 'Siswa',
            'nama_pelapor' => 'Budi Santoso',
            'kontak' => '081234567890',
            'judul' => 'Kabel AC Putus di Lab Komputer',
            'lokasi' => 'Lab Komputer 1',
            'uraian' => 'Kabel stop kontak AC terkelupas dan membahayakan siswa saat praktek.',
            'urgensi_pelapor' => 'Ada risiko keselamatan',
            'bukti_pelapor_file' => $file,
        ];

        $response = $this->post('/pengaduan', $payload);

        $pengaduan = Pengaduan::where('judul', 'Kabel AC Putus di Lab Komputer')->first();
        $this->assertNotNull($pengaduan);
        $this->assertNotNull($pengaduan->bukti_pelapor);

        // Verify stored path has .webp extension
        $this->assertStringEndsWith('.webp', $pengaduan->bukti_pelapor);

        // Verify file actually exists on public disk
        Storage::disk('public')->assertExists($pengaduan->bukti_pelapor);

        // Verify the stored file content is valid WebP binary (RIFF....WEBP)
        $content = Storage::disk('public')->get($pengaduan->bukti_pelapor);
        $this->assertStringStartsWith('RIFF', $content);
        $this->assertStringContainsString('WEBP', substr($content, 0, 16));

        $response->assertRedirect(route('pengaduan.track', ['ticket' => $pengaduan->ticket_number]));
    }

    public function test_resolution_evidence_image_is_converted_to_webp(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $pengaduan = Pengaduan::create([
            'ticket_number' => 'TKT-2026-5555',
            'kategori' => 'Sarana dan prasarana',
            'jenis_pelapor' => 'Guru',
            'nama_pelapor' => 'Ibu Guru Ani',
            'judul' => 'Lampu LED Bengkel Mesin Mati',
            'uraian' => 'Lampu penerangan di atas mesin bubut 2 mati.',
            'urgensi_pelapor' => 'Normal',
            'status' => 'dalam_proses',
            'tanggal_lapor' => now(),
        ]);

        $evidenceFile = UploadedFile::fake()->image('bukti_sesudah.png', 800, 600);

        $response = $this->actingAs($admin)->post("/petugas/pengaduan/{$pengaduan->id}/resolve", [
            'catatan_petugas' => 'Lampu telah diganti dengan modul LED 18 watt yang baru dan menyala terang.',
            'suku_cadang' => '1x Lampu LED Philips 18W',
            'bukti_petugas_file' => $evidenceFile,
        ]);

        $pengaduan->refresh();
        $this->assertEquals('menunggu_konfirmasi', $pengaduan->status);
        $this->assertNotNull($pengaduan->bukti_petugas);
        $this->assertStringEndsWith('.webp', $pengaduan->bukti_petugas);

        Storage::disk('public')->assertExists($pengaduan->bukti_petugas);
        $response->assertRedirect(route('admin.dashboard'));
    }

    public function test_database_seeder_cleans_dummy_and_only_seeds_admin(): void
    {
        // Run database seeder
        $this->seed(DatabaseSeeder::class);

        // Verify only 1 user exists and has admin role
        $this->assertEquals(1, User::count());
        $admin = User::first();
        $this->assertEquals('admin', $admin->role);
        $this->assertEquals('admin.pengaduan@smkn2kra.sch.id', $admin->email);

        // Verify zero dummy complaints exist
        $this->assertEquals(0, Pengaduan::count());
    }
}
