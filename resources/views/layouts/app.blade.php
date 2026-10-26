<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'SIADU' }} — Layanan Pengaduan & Aspirasi SMKN 2 Karanganyar</title>
    <meta name="description" content="{{ $description ?? 'Portal Resmi Sistem Informasi Pengaduan & Aspirasi SMKN 2 Karanganyar. Kanal resmi pelaporan sarana prasarana, keluhan akademik, administrasi, dan perlindungan siswa.' }}">
    
    <!-- PWA Meta Tags -->
    <link rel="manifest" href="/manifest.webmanifest">
    <meta name="theme-color" content="#0a192f">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="SIADU SMKN 2">
    <link rel="apple-touch-icon" href="https://smkn2kra.sch.id/images/logo-smkn2kra.png">
    <link rel="icon" type="image/png" href="https://smkn2kra.sch.id/images/logo-smkn2kra.png">

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- FontAwesome 6 Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Vite Assets (Tailwind CSS 4 & Alpine.js) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body class="bg-[#f8fafc] text-slate-800 antialiased font-sans selection:bg-blue-700 selection:text-white min-h-screen flex flex-col justify-between pb-16 md:pb-0">

    <!-- Institutional Top Bar -->
    <div class="bg-[#0a192f] text-slate-300 text-xs py-2 px-4 border-b border-slate-800/80">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row justify-between items-center gap-2">
            <div class="flex items-center gap-2 text-center sm:text-left text-[11px] sm:text-xs">
                <span class="inline-flex items-center px-1.5 py-0.5 rounded font-bold bg-amber-500/20 text-amber-300 border border-amber-400/30 text-[10px] uppercase tracking-wider shrink-0">
                    RESMI
                </span>
                <span class="text-slate-300 font-medium">Kanal Pengaduan & Aspirasi Warga Sekolah SMK Negeri 2 Karanganyar</span>
            </div>
            <div class="flex items-center gap-3.5 text-slate-400 text-[11px]">
                <span class="hidden md:inline text-slate-400">
                    <i class="fa-regular fa-clock mr-1 text-slate-400"></i> Jam Layanan: 07.00 - 15.30 WIB
                </span>
                <span class="hidden md:inline text-slate-700">|</span>
                <span class="flex items-center gap-1 text-slate-300">
                    <i class="fa-solid fa-phone text-[10px] text-emerald-400"></i> (0271) 494549
                </span>
                <span class="text-slate-700">|</span>
                @auth
                    <div class="flex items-center gap-2">
                        <span class="text-slate-200 font-medium truncate max-w-[150px]">
                            {{ auth()->user()->name }}
                        </span>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-rose-300 hover:text-rose-200 font-semibold transition ml-1">
                                Keluar
                            </button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-blue-300 hover:text-white font-medium flex items-center gap-1 transition">
                        <i class="fa-solid fa-lock text-[10px]"></i> Masuk Admin
                    </a>
                @endauth
            </div>
        </div>
    </div>

    <!-- Header Navigation Bar -->
    <x-navbar />

    <!-- Flash Messages (Alerts) -->
    <x-flash-messages />

    <!-- Main Content Slot -->
    <main class="flex-1 w-full">
        {{ $slot }}
    </main>

    <!-- Professional Institutional Footer -->
    <footer class="bg-[#0a192f] text-slate-400 text-xs border-t border-slate-800 mt-16 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-8 pb-10 border-b border-slate-800/80">
                
                <!-- School Profile & Identity -->
                <div class="md:col-span-5 space-y-3.5">
                    <div class="flex items-center gap-3">
                        <img 
                            src="https://smkn2kra.sch.id/images/logo-smkn2kra.png" 
                            alt="Logo SMKN 2 Karanganyar" 
                            class="h-11 w-auto"
                            onerror="this.onerror=null; this.src='https://placehold.co/100x100/1e293b/ffffff?text=SMK';"
                        >
                        <div>
                            <span class="text-white font-bold text-sm tracking-tight block">SMK NEGERI 2 KARANGANYAR</span>
                            <span class="text-slate-400 text-xs font-medium">SIADU — Layanan Pengaduan & Aspirasi Digital</span>
                        </div>
                    </div>
                    <p class="text-slate-400 text-xs leading-relaxed max-w-md">
                        Kanal resmi penanganan gangguan fasilitas belajar, pelaporan sarana prasarana, keluhan akademik, administrasi kesiswaan, serta perlindungan tindak kekerasan dan perundungan di lingkungan sekolah.
                    </p>
                    <div class="pt-1 flex items-center gap-2 text-[11px] text-slate-400">
                        <span class="px-2 py-0.5 rounded bg-slate-800 text-slate-300 border border-slate-700 font-semibold">NPSN: 20312061</span>
                        <span class="px-2 py-0.5 rounded bg-slate-800 text-slate-300 border border-slate-700 font-semibold">Akreditasi A</span>
                    </div>
                </div>

                <!-- Fast Navigation -->
                <div class="md:col-span-3 space-y-3">
                    <h5 class="text-white font-bold text-xs uppercase tracking-wider">Akses Layanan</h5>
                    <ul class="space-y-2 text-xs">
                        <li><a href="{{ route('home') }}" class="hover:text-white transition">Beranda Utama</a></li>
                        <li><a href="{{ route('pengaduan.create') }}" class="hover:text-white transition">Formulir Pengaduan</a></li>
                        <li><a href="{{ route('pengaduan.history') }}" class="hover:text-white transition">Riwayat Pengaduan Publik</a></li>
                        <li><a href="{{ route('pengaduan.track') }}" class="hover:text-white transition">Lacak Progres Tiket</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-white transition">Portal Masuk Administrator</a></li>
                    </ul>
                </div>

                <!-- Contact & Working Hours -->
                <div class="md:col-span-4 space-y-3">
                    <h5 class="text-white font-bold text-xs uppercase tracking-wider">Sekretariat Pelayanan</h5>
                    <div class="space-y-1.5 text-xs text-slate-300 leading-relaxed">
                        <p class="flex items-start gap-2">
                            <i class="fa-solid fa-location-dot text-slate-400 mt-0.5"></i>
                            <span>Jl. Yos Sudarso, Jarsari, Karanganyar, Jawa Tengah 57716</span>
                        </p>
                        <p class="flex items-center gap-2">
                            <i class="fa-solid fa-phone text-slate-400"></i>
                            <span>(0271) 494549 (Pos Piket & Hotline)</span>
                        </p>
                        <p class="flex items-center gap-2">
                            <i class="fa-solid fa-envelope text-slate-400"></i>
                            <span>pengaduan@smkn2kra.sch.id</span>
                        </p>
                    </div>
                    <div class="p-2.5 rounded-xl bg-slate-900 border border-slate-800 text-[11px] text-slate-400">
                        <i class="fa-solid fa-circle-exclamation text-amber-400 mr-1.5"></i>
                        Darurat keselamatan fisik/kebakaran: Segera hubungi pos piket kantor utama.
                    </div>
                </div>

            </div>

            <!-- Bottom Copyright & Compliance -->
            <div class="pt-6 flex flex-col sm:flex-row items-center justify-between gap-3 text-[11px] text-slate-500">
                <p>&copy; {{ date('Y') }} SMK Negeri 2 Karanganyar. Hak Cipta Dilindungi Undang-Undang.</p>
                <div class="flex items-center gap-3">
                    <span>SOP Penanganan Aduan SMKN 2 Karanganyar</span>
                    <span>•</span>
                    <span>Versi Sistem 2.4</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Native-style Bottom Navigation for Mobile -->
    <x-mobile-bottom-nav />

    <!-- Service Worker Registration for PWA -->
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js').catch(() => {});
            });
        }
    </script>

    @stack('scripts')
</body>
</html>
