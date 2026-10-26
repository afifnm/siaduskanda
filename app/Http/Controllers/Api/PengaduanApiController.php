<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\FeedbackPengaduanRequest;
use App\Http\Requests\StorePengaduanRequest;
use App\Models\Pengaduan;
use App\Services\PengaduanService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PengaduanApiController extends Controller
{
    public function __construct(
        protected PengaduanService $pengaduanService
    ) {}

    /**
     * Get statistics summary
     */
    public function stats(): JsonResponse
    {
        $stats = $this->pengaduanService->getDashboardStats();

        return response()->json([
            'success' => true,
            'message' => 'Statistik aduan berhasil diambil.',
            'data' => $stats,
        ]);
    }

    /**
     * Get recent complaints (public)
     */
    public function index(Request $request): JsonResponse
    {
        $reports = Pengaduan::with('petugas')
            ->filterStatus($request->query('status'))
            ->filterKategori($request->query('kategori'))
            ->search($request->query('search'))
            ->latest('tanggal_lapor')
            ->paginate($request->query('per_page', 10));

        return response()->json([
            'success' => true,
            'message' => 'Daftar pengaduan berhasil dimuat.',
            'data' => $reports,
        ]);
    }

    /**
     * Submit new complaint
     */
    public function store(StorePengaduanRequest $request): JsonResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('bukti_pelapor_file')) {
            $validated['bukti_pelapor_file'] = $request->file('bukti_pelapor_file');
        }

        $pengaduan = $this->pengaduanService->createComplaint($validated, $request->user());

        return response()->json([
            'success' => true,
            'message' => 'Laporan pengaduan berhasil didaftarkan.',
            'data' => [
                'ticket_number' => $pengaduan->ticket_number,
                'judul' => $pengaduan->judul,
                'kategori' => $pengaduan->kategori,
                'status' => $pengaduan->status,
                'tanggal_lapor' => $pengaduan->tanggal_lapor->toIso8601String(),
                'track_url' => route('pengaduan.track', ['ticket' => $pengaduan->ticket_number]),
            ],
        ], 201);
    }

    /**
     * Track a complaint by ticket number
     */
    public function show(string $ticketNumber): JsonResponse
    {
        $pengaduan = Pengaduan::with(['petugas', 'histories'])
            ->where('ticket_number', $ticketNumber)
            ->first();

        if (! $pengaduan) {
            return response()->json([
                'success' => false,
                'message' => "Nomor tiket {$ticketNumber} tidak ditemukan dalam sistem.",
                'errors' => [
                    'ticket_number' => ['Tiket tidak ditemukan'],
                ],
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data tiket berhasil ditemukan.',
            'data' => [
                'id' => $pengaduan->id,
                'ticket_number' => $pengaduan->ticket_number,
                'judul' => $pengaduan->judul,
                'kategori' => $pengaduan->kategori,
                'kategori_definitif' => $pengaduan->kategori_definitif,
                'jenis_pelapor' => $pengaduan->jenis_pelapor,
                'nama_pelapor' => $pengaduan->is_anonim ? 'Pelapor Anonim' : $pengaduan->nama_pelapor,
                'lokasi' => $pengaduan->lokasi,
                'uraian' => $pengaduan->uraian,
                'urgensi' => $pengaduan->effective_urgensi,
                'status' => $pengaduan->status,
                'status_label' => $pengaduan->status_label,
                'step_index' => $pengaduan->step_index,
                'bukti_pelapor' => $pengaduan->bukti_pelapor_url,
                'unit_tujuan' => $pengaduan->unit_tujuan,
                'petugas' => $pengaduan->nama_petugas,
                'deadline' => $pengaduan->deadline?->translatedFormat('d M Y H:i'),
                'catatan_petugas' => $pengaduan->catatan_petugas,
                'suku_cadang' => $pengaduan->suku_cadang,
                'bukti_petugas' => $pengaduan->bukti_petugas_url,
                'catatan_admin' => $pengaduan->catatan_admin,
                'admin_close_feedback' => $pengaduan->admin_close_feedback,
                'rating' => $pengaduan->rating,
                'ulasan_pelapor' => $pengaduan->ulasan_pelapor,
                'tanggal_lapor' => $pengaduan->tanggal_lapor->translatedFormat('d M Y H:i'),
                'tanggal_selesai' => $pengaduan->tanggal_selesai?->translatedFormat('d M Y H:i'),
                'histories' => $pengaduan->histories->map(fn ($h) => [
                    'action_title' => $h->action_title,
                    'actor_name' => $h->actor_name,
                    'notes' => $h->notes,
                    'status_to' => $h->status_to,
                    'time' => $h->created_at->translatedFormat('d M Y, H:i'),
                ]),
            ],
        ]);
    }

    /**
     * Submit feedback via API
     */
    public function feedback(FeedbackPengaduanRequest $request, string $ticketNumber): JsonResponse
    {
        $pengaduan = Pengaduan::where('ticket_number', $ticketNumber)->first();

        if (! $pengaduan) {
            return response()->json([
                'success' => false,
                'message' => 'Tiket tidak ditemukan.',
                'errors' => ['ticket_number' => ['Tiket tidak valid']],
            ], 404);
        }

        $this->pengaduanService->submitFeedback($pengaduan, $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Ulasan berhasil disimpan.',
            'data' => [
                'ticket_number' => $pengaduan->ticket_number,
                'rating' => $pengaduan->rating,
                'ulasan_pelapor' => $pengaduan->ulasan_pelapor,
            ],
        ]);
    }
}
