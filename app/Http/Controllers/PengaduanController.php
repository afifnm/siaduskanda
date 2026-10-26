<?php

namespace App\Http\Controllers;

use App\Http\Requests\FeedbackPengaduanRequest;
use App\Http\Requests\StorePengaduanRequest;
use App\Models\Pengaduan;
use App\Services\PengaduanService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PengaduanController extends Controller
{
    public function __construct(
        protected PengaduanService $pengaduanService
    ) {}

    public function history(Request $request): View
    {
        $status = $request->query('status');
        $kategori = $request->query('kategori');
        $search = $request->query('search');
        $sortBy = $request->query('sort', 'latest');

        $query = Pengaduan::with(['petugas'])
            ->filterStatus($status)
            ->filterKategori($kategori)
            ->search($search);

        if ($sortBy === 'oldest') {
            $query->oldest('tanggal_lapor');
        } elseif ($sortBy === 'urgensi') {
            $query->orderByRaw("CASE 
                WHEN COALESCE(urgensi_admin, urgensi_pelapor) = 'Ada risiko keselamatan' THEN 1 
                WHEN COALESCE(urgensi_admin, urgensi_pelapor) = 'Mendesak' THEN 2 
                ELSE 3 
            END")
                ->latest('tanggal_lapor');
        } else {
            $query->latest('tanggal_lapor');
        }

        $pengaduans = $query->paginate(9)->withQueryString();
        $stats = $this->pengaduanService->getDashboardStats();

        return view('pengaduan.history', compact('pengaduans', 'stats', 'status', 'kategori', 'search', 'sortBy'));
    }

    public function create(): View
    {
        return view('pengaduan.create');
    }

    public function store(StorePengaduanRequest $request): RedirectResponse|JsonResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('bukti_pelapor_file')) {
            $validated['bukti_pelapor_file'] = $request->file('bukti_pelapor_file');
        }

        $pengaduan = $this->pengaduanService->createComplaint($validated, $request->user());

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Laporan pengaduan berhasil dikirim.',
                'data' => [
                    'id' => $pengaduan->ticket_number,
                    'ticket_number' => $pengaduan->ticket_number,
                    'judul' => $pengaduan->judul,
                    'kategori' => $pengaduan->kategori,
                    'urgensiPelapor' => $pengaduan->urgensi_pelapor,
                    'redirect_url' => route('pengaduan.track', ['ticket' => $pengaduan->ticket_number]),
                ],
            ], 201);
        }

        return redirect()->route('pengaduan.track', ['ticket' => $pengaduan->ticket_number])
            ->with('success', 'Laporan Anda berhasil dikirim dengan Nomor Tiket #'.$pengaduan->ticket_number);
    }

    public function track(Request $request): View
    {
        $ticketQuery = trim($request->query('ticket', ''));
        $ticketData = null;
        $ticketNotFound = false;

        if ($ticketQuery !== '') {
            $ticketData = Pengaduan::with(['petugas', 'histories'])
                ->where('ticket_number', $ticketQuery)
                ->first();

            if (! $ticketData) {
                $ticketNotFound = true;
            }
        } else {
            // Default load sample ticket for immediate demonstration review
            $ticketData = Pengaduan::with(['petugas', 'histories'])
                ->where('ticket_number', 'TKT-2026-0482')
                ->first();

            if ($ticketData) {
                $ticketQuery = $ticketData->ticket_number;
            }
        }

        return view('pengaduan.track', compact('ticketQuery', 'ticketData', 'ticketNotFound'));
    }

    public function submitFeedback(FeedbackPengaduanRequest $request, Pengaduan $pengaduan): RedirectResponse|JsonResponse
    {
        $validated = $request->validated();
        $this->pengaduanService->submitFeedback($pengaduan, $validated);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Terima kasih atas ulasan dan penilaian yang Anda berikan.',
                'data' => $pengaduan->fresh(),
            ]);
        }

        return redirect()->route('pengaduan.track', ['ticket' => $pengaduan->ticket_number])
            ->with('success', 'Terima kasih, ulasan kepuasan Anda telah berhasil disimpan.');
    }
}
