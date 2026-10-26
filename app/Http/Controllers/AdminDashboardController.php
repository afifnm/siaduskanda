<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssignPengaduanRequest;
use App\Http\Requests\ClosePengaduanRequest;
use App\Models\Pengaduan;
use App\Services\PengaduanService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function __construct(
        protected PengaduanService $pengaduanService
    ) {}

    public function index(Request $request): View
    {
        $status = $request->query('status', 'all');
        $kategori = $request->query('kategori', 'all');
        $search = $request->query('search', '');

        $reportsQuery = Pengaduan::with(['petugas', 'pelapor'])
            ->filterStatus($status)
            ->filterKategori($kategori)
            ->search($search)
            ->latest('tanggal_lapor');

        $reports = $reportsQuery->get();
        $stats = $this->pengaduanService->getDashboardStats();

        return view('admin.dashboard', compact('reports', 'stats', 'status', 'kategori', 'search'));
    }

    public function assign(AssignPengaduanRequest $request, Pengaduan $pengaduan): RedirectResponse|JsonResponse
    {
        $validated = $request->validated();
        $updated = $this->pengaduanService->assignComplaint($pengaduan, $validated, $request->user());

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Tiket #{$pengaduan->ticket_number} berhasil diverifikasi dan ditugaskan ke {$updated->unit_tujuan}.",
                'data' => $updated,
            ]);
        }

        return redirect()->route('admin.dashboard')
            ->with('success', "Tiket #{$pengaduan->ticket_number} berhasil diverifikasi dan ditugaskan ke {$updated->unit_tujuan}.");
    }

    public function close(ClosePengaduanRequest $request, Pengaduan $pengaduan): RedirectResponse|JsonResponse
    {
        $validated = $request->validated();
        $updated = $this->pengaduanService->closeComplaint($pengaduan, $validated, $request->user());

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Tiket #{$pengaduan->ticket_number} telah disetujui dan resmi ditutup tuntas.",
                'data' => $updated,
            ]);
        }

        return redirect()->route('admin.dashboard')
            ->with('success', "Tiket #{$pengaduan->ticket_number} telah disetujui dan resmi ditutup tuntas.");
    }
}
