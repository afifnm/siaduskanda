<?php

namespace Tests\Feature;

use App\Models\Pengaduan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiPengaduanTest extends TestCase
{
    use RefreshDatabase;

    public function test_api_stats_returns_correct_json_structure(): void
    {
        $response = $this->getJson('/api/v1/stats');

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'Statistik aduan berhasil diambil.',
        ]);
        $response->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'total',
                'masuk',
                'terverifikasi',
                'proses',
                'konfirmasi',
                'selesai',
            ],
        ]);
    }

    public function test_api_can_submit_complaint(): void
    {
        $payload = [
            'kategori' => 'Sarana dan prasarana',
            'jenis_pelapor' => 'Siswa',
            'nama_pelapor' => 'Siswa API',
            'kontak' => '081299990000',
            'judul' => 'Lampu Kelas Mati di Ruang 11 TKR',
            'lokasi' => 'Ruang 11 TKR',
            'uraian' => 'Lampu LED di bagian depan berkedip-kedip lalu mati total.',
            'urgensi_pelapor' => 'Normal',
        ];

        $response = $this->postJson('/api/v1/pengaduan', $payload);

        $response->assertStatus(201);
        $response->assertJson([
            'success' => true,
            'message' => 'Laporan pengaduan berhasil didaftarkan.',
        ]);
        $response->assertJsonPath('data.judul', 'Lampu Kelas Mati di Ruang 11 TKR');
    }

    public function test_api_can_track_complaint(): void
    {
        $pengaduan = Pengaduan::create([
            'ticket_number' => 'TKT-2026-7777',
            'kategori' => 'Sarana dan prasarana',
            'jenis_pelapor' => 'Guru',
            'nama_pelapor' => 'Guru API',
            'judul' => 'Kerusakan Mikroskop Lab IPA',
            'uraian' => 'Lensa objektif mikroskop nomor 3 buram dan berjamur.',
            'urgensi_pelapor' => 'Normal',
            'status' => 'masuk',
            'tanggal_lapor' => now(),
        ]);

        $response = $this->getJson('/api/v1/pengaduan/TKT-2026-7777');

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'data' => [
                'ticket_number' => 'TKT-2026-7777',
                'judul' => 'Kerusakan Mikroskop Lab IPA',
                'status' => 'masuk',
            ],
        ]);
    }

    public function test_api_returns_404_for_unknown_ticket(): void
    {
        $response = $this->getJson('/api/v1/pengaduan/TKT-UNKNOWN');

        $response->assertStatus(404);
        $response->assertJson([
            'success' => false,
            'message' => 'Nomor tiket TKT-UNKNOWN tidak ditemukan dalam sistem.',
        ]);
    }
}
