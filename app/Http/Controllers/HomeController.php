<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Services\PengaduanService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __construct(
        protected PengaduanService $pengaduanService
    ) {}

    public function index(Request $request): View
    {
        $stats = $this->pengaduanService->getDashboardStats();

        $recentReports = Pengaduan::query()
            ->latest('tanggal_lapor')
            ->take(6)
            ->get();

        return view('home', compact('stats', 'recentReports'));
    }
}
