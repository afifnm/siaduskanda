<?php

namespace App\Services;

use App\Models\Pengaduan;
use App\Models\PengaduanHistory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class PengaduanService
{
    public function __construct(
        protected ImageOptimizerService $imageOptimizer
    ) {}

    /**
     * Generate unique ticket number format: TKT-2026-0482
     */
    public function generateTicketNumber(): string
    {
        $year = Carbon::now()->year;

        do {
            $randomDigits = str_pad((string) random_int(100, 9999), 4, '0', STR_PAD_LEFT);
            $ticketNumber = "TKT-{$year}-{$randomDigits}";
        } while (Pengaduan::where('ticket_number', $ticketNumber)->exists());

        return $ticketNumber;
    }

    /**
     * Store complaint from public/user
     */
    public function createComplaint(array $data, ?User $user = null): Pengaduan
    {
        return DB::transaction(function () use ($data, $user) {
            $ticketNumber = $this->generateTicketNumber();
            $buktiPath = null;

            if (isset($data['bukti_pelapor_file']) && $data['bukti_pelapor_file'] instanceof UploadedFile) {
                $buktiPath = $this->imageOptimizer->convertToWebp($data['bukti_pelapor_file'], 'pengaduan/pelapor');
            } elseif (! empty($data['bukti_pelapor'])) {
                // If base64 or URL
                $buktiPath = $this->handleImagePayload($data['bukti_pelapor'], 'pelapor');
            }

            $isAnonim = (bool) ($data['is_anonim'] ?? false);
            $namaPelapor = $isAnonim ? 'Pelapor Anonim' : ($data['nama_pelapor'] ?? ($user?->name ?? 'Warga SMKN 2 Kra'));
            $kontak = $isAnonim ? '-' : ($data['kontak'] ?? '-');

            $pengaduan = Pengaduan::create([
                'ticket_number' => $ticketNumber,
                'user_id' => $user?->id,
                'kategori' => $data['kategori'],
                'kategori_definitif' => null,
                'jenis_pelapor' => $data['jenis_pelapor'] ?? 'Siswa',
                'nama_pelapor' => $namaPelapor,
                'kontak' => $kontak,
                'is_anonim' => $isAnonim,
                'judul' => $data['judul'],
                'lokasi' => $data['lokasi'] ?? null,
                'uraian' => $data['uraian'],
                'urgensi_pelapor' => $data['urgensi_pelapor'] ?? Pengaduan::URGENSI_NORMAL,
                'urgensi_admin' => null,
                'bukti_pelapor' => $buktiPath,
                'status' => Pengaduan::STATUS_MASUK,
                'tanggal_lapor' => Carbon::now(),
            ]);

            // Create initial history log
            PengaduanHistory::create([
                'pengaduan_id' => $pengaduan->id,
                'user_id' => $user?->id,
                'actor_name' => $namaPelapor,
                'status_from' => null,
                'status_to' => Pengaduan::STATUS_MASUK,
                'action_title' => 'Laporan Masuk',
                'notes' => 'Pengaduan berhasil didaftarkan ke sistem SIADU SMKN 2 Karanganyar.',
                'created_at' => Carbon::now(),
            ]);

            return $pengaduan;
        });
    }

    /**
     * Admin assigns ticket to unit & officer
     */
    public function assignComplaint(Pengaduan $pengaduan, array $data, User $admin): Pengaduan
    {
        return DB::transaction(function () use ($pengaduan, $data, $admin) {
            $statusFrom = $pengaduan->status;

            // Resolve Petugas user if given by ID or name
            $petugasId = $data['petugas_id'] ?? null;
            $namaPetugas = $data['nama_petugas'] ?? null;

            if ($petugasId) {
                $petugasUser = User::find($petugasId);
                if ($petugasUser) {
                    $namaPetugas = $petugasUser->name;
                }
            } elseif ($namaPetugas) {
                // Try finding matching user by name
                $petugasUser = User::where('name', 'like', "%{$namaPetugas}%")->first();
                if ($petugasUser) {
                    $petugasId = $petugasUser->id;
                }
            }

            // Deadline calculation
            $deadline = null;
            if (! empty($data['deadline'])) {
                $deadline = Carbon::parse($data['deadline']);
            } elseif (! empty($data['deadline_hours'])) {
                $deadline = Carbon::now()->addHours((int) $data['deadline_hours']);
            } else {
                $deadline = Carbon::now()->addHours(48); // default 2 days
            }

            $pengaduan->update([
                'kategori_definitif' => $data['kategori_definitif'] ?? $pengaduan->kategori,
                'urgensi_admin' => $data['urgensi_admin'] ?? $pengaduan->urgensi_pelapor,
                'unit_tujuan' => $data['unit_tujuan'],
                'petugas_id' => $petugasId,
                'nama_petugas' => $namaPetugas,
                'deadline' => $deadline,
                'catatan_admin' => $data['catatan_admin'] ?? null,
                'status' => Pengaduan::STATUS_TERVERIFIKASI,
            ]);

            PengaduanHistory::create([
                'pengaduan_id' => $pengaduan->id,
                'user_id' => $admin->id,
                'actor_name' => $admin->name,
                'status_from' => $statusFrom,
                'status_to' => Pengaduan::STATUS_TERVERIFIKASI,
                'action_title' => 'Verifikasi & Penugasan Unit',
                'notes' => "Ditugaskan ke {$pengaduan->unit_tujuan} (PIC: {$namaPetugas}). Target penyelesaian: ".($deadline ? $deadline->translatedFormat('d M Y H:i') : 'Sesuai SOP').'. Catatan: '.($data['catatan_admin'] ?? '-'),
                'created_at' => Carbon::now(),
            ]);

            return $pengaduan->fresh(['pelapor', 'petugas', 'histories']);
        });
    }

    /**
     * Petugas starts physical/technical handling
     */
    public function startHandling(Pengaduan $pengaduan, User $petugas): Pengaduan
    {
        return DB::transaction(function () use ($pengaduan, $petugas) {
            $statusFrom = $pengaduan->status;

            $pengaduan->update([
                'status' => Pengaduan::STATUS_DALAM_PROSES,
                'petugas_id' => $pengaduan->petugas_id ?: $petugas->id,
                'nama_petugas' => $pengaduan->nama_petugas ?: $petugas->name,
            ]);

            PengaduanHistory::create([
                'pengaduan_id' => $pengaduan->id,
                'user_id' => $petugas->id,
                'actor_name' => $petugas->name,
                'status_from' => $statusFrom,
                'status_to' => Pengaduan::STATUS_DALAM_PROSES,
                'action_title' => 'Mulai Penanganan Lapangan',
                'notes' => 'Petugas memulai pemeriksaan fisik, investigasi teknis, atau penanganan di lokasi.',
                'created_at' => Carbon::now(),
            ]);

            return $pengaduan->fresh(['pelapor', 'petugas', 'histories']);
        });
    }

    /**
     * Petugas submits resolution, notes, spare parts, and after-photo
     */
    public function submitResolution(Pengaduan $pengaduan, array $data, User $petugas): Pengaduan
    {
        return DB::transaction(function () use ($pengaduan, $data, $petugas) {
            $statusFrom = $pengaduan->status;
            $buktiPetugasPath = $pengaduan->bukti_petugas;

            if (isset($data['bukti_petugas_file']) && $data['bukti_petugas_file'] instanceof UploadedFile) {
                $buktiPetugasPath = $this->imageOptimizer->convertToWebp($data['bukti_petugas_file'], 'pengaduan/petugas');
            } elseif (! empty($data['bukti_petugas'])) {
                $buktiPetugasPath = $this->handleImagePayload($data['bukti_petugas'], 'petugas');
            }

            $pengaduan->update([
                'catatan_petugas' => $data['catatan_petugas'] ?? null,
                'suku_cadang' => $data['suku_cadang'] ?? null,
                'bukti_petugas' => $buktiPetugasPath,
                'status' => Pengaduan::STATUS_MENUNGGU_KONFIRMASI,
            ]);

            PengaduanHistory::create([
                'pengaduan_id' => $pengaduan->id,
                'user_id' => $petugas->id,
                'actor_name' => $petugas->name,
                'status_from' => $statusFrom,
                'status_to' => Pengaduan::STATUS_MENUNGGU_KONFIRMASI,
                'action_title' => 'Penanganan Selesai Diajukan',
                'notes' => 'Petugas telah menyelesaikan tindakan dan melampirkan bukti dokumentasi pengerjaan. Menunggu verifikasi akhir penutupan oleh Admin.',
                'created_at' => Carbon::now(),
            ]);

            return $pengaduan->fresh(['pelapor', 'petugas', 'histories']);
        });
    }

    /**
     * Admin approves completion and officially closes ticket
     */
    public function closeComplaint(Pengaduan $pengaduan, array $data, User $admin): Pengaduan
    {
        return DB::transaction(function () use ($pengaduan, $data, $admin) {
            $statusFrom = $pengaduan->status;

            $pengaduan->update([
                'status' => Pengaduan::STATUS_SELESAI,
                'admin_close_feedback' => $data['admin_close_feedback'] ?? 'Pekerjaan telah diverifikasi dan berfungsi baik sesuai standar SOP SMKN 2 Karanganyar.',
                'tanggal_selesai' => Carbon::now(),
            ]);

            PengaduanHistory::create([
                'pengaduan_id' => $pengaduan->id,
                'user_id' => $admin->id,
                'actor_name' => $admin->name,
                'status_from' => $statusFrom,
                'status_to' => Pengaduan::STATUS_SELESAI,
                'action_title' => 'Pengaduan Selesai Tuntas',
                'notes' => $pengaduan->admin_close_feedback,
                'created_at' => Carbon::now(),
            ]);

            return $pengaduan->fresh(['pelapor', 'petugas', 'histories']);
        });
    }

    /**
     * Pelapor submits satisfaction rating and feedback
     */
    public function submitFeedback(Pengaduan $pengaduan, array $data): Pengaduan
    {
        $pengaduan->update([
            'rating' => (int) ($data['rating'] ?? 5),
            'ulasan_pelapor' => $data['ulasan_pelapor'] ?? null,
        ]);

        return $pengaduan;
    }

    /**
     * Dashboard statistics aggregation
     */
    public function getDashboardStats(?User $user = null): array
    {
        $query = Pengaduan::query();

        if ($user && $user->isPetugas()) {
            // Petugas sees tickets assigned to him or his unit, or in general verification
            $query->where(function ($q) use ($user) {
                $q->where('petugas_id', $user->id)
                    ->orWhere('unit_tujuan', $user->unit)
                    ->orWhere('status', '!=', Pengaduan::STATUS_MASUK);
            });
        }

        $all = $query->get();

        return [
            'total' => $all->count(),
            'masuk' => $all->where('status', Pengaduan::STATUS_MASUK)->count(),
            'terverifikasi' => $all->where('status', Pengaduan::STATUS_TERVERIFIKASI)->count(),
            'proses' => $all->where('status', Pengaduan::STATUS_DALAM_PROSES)->count(),
            'konfirmasi' => $all->where('status', Pengaduan::STATUS_MENUNGGU_KONFIRMASI)->count(),
            'selesai' => $all->where('status', Pengaduan::STATUS_SELESAI)->count(),
        ];
    }

    /**
     * Helper to process image payload (URL or base64 data)
     */
    protected function handleImagePayload(string $raw, string $folder): string
    {
        // If it's a remote URL
        if (str_starts_with($raw, 'http://') || str_starts_with($raw, 'https://')) {
            return $raw;
        }

        // If it's base64 data URL
        if (preg_match('/^data:image\/(\w+);base64,/', $raw)) {
            return $this->imageOptimizer->convertToWebp($raw, 'pengaduan/'.$folder);
        }

        return $raw;
    }
}
