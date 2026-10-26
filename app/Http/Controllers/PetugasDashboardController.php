<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResolvePengaduanRequest;
use App\Models\Pengaduan;
use App\Services\PengaduanService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PetugasDashboardController extends Controller
{
    public function __construct(
        protected PengaduanService $pengaduanService
    ) {}

    public function index(Request $request): View
    {
        $user = $request->user();
        $tab = $request->query('tab', 'semua');

        // Petugas sees tasks that have been assigned (status != masuk)
        $tasksQuery = Pengaduan::with(['pelapor', 'petugas'])
            ->where('status', '!=', Pengaduan::STATUS_MASUK)
            ->latest('tanggal_lapor');

        if ($tab === 'baru') {
            $tasksQuery->where('status', Pengaduan::STATUS_TERVERIFIKASI);
        } elseif ($tab === 'proses') {
            $tasksQuery->where('status', Pengaduan::STATUS_DALAM_PROSES);
        } elseif ($tab === 'selesai') {
            $tasksQuery->whereIn('status', [Pengaduan::STATUS_MENUNGGU_KONFIRMASI, Pengaduan::STATUS_SELESAI]);
        }

        $tasks = $tasksQuery->get();

        // Calculate stats for Petugas
        $allAssigned = Pengaduan::where('status', '!=', Pengaduan::STATUS_MASUK)->get();
        $stats = [
            'total' => $allAssigned->count(),
            'baru' => $allAssigned->where('status', Pengaduan::STATUS_TERVERIFIKASI)->count(),
            'proses' => $allAssigned->where('status', Pengaduan::STATUS_DALAM_PROSES)->count(),
            'selesai' => $allAssigned->whereIn('status', [Pengaduan::STATUS_MENUNGGU_KONFIRMASI, Pengaduan::STATUS_SELESAI])->count(),
        ];

        return view('petugas.dashboard', compact('tasks', 'stats', 'tab', 'user'));
    }

    public function start(Request $request, Pengaduan $pengaduan): RedirectResponse|JsonResponse
    {
        $updated = $this->pengaduanService->startHandling($pengaduan, $request->user());

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Penanganan tiket #{$pengaduan->ticket_number} telah dimulai.",
                'data' => $updated,
            ]);
        }

        return redirect()->route('admin.dashboard')
            ->with('success', "Penanganan tiket #{$pengaduan->ticket_number} telah dimulai. Status berubah ke Sedang Ditangani.");
    }

    public function resolve(ResolvePengaduanRequest $request, Pengaduan $pengaduan): RedirectResponse|JsonResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('bukti_petugas_file')) {
            $validated['bukti_petugas_file'] = $request->file('bukti_petugas_file');
        }

        $updated = $this->pengaduanService->submitResolution($pengaduan, $validated, $request->user());

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Hasil pekerjaan dan bukti penyelesaian untuk tiket #{$pengaduan->ticket_number} telah diajukan ke Admin.",
                'data' => $updated,
            ]);
        }

        return redirect()->route('admin.dashboard')
            ->with('success', "Hasil pekerjaan untuk tiket #{$pengaduan->ticket_number} berhasil diserahkan dan menunggu konfirmasi penutupan.");
    }
}
