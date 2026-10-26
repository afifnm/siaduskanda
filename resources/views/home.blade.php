<x-app-layout>
    <x-slot:title>Beranda — SIADU Layanan Pengaduan SMKN 2 Karanganyar</x-slot:title>

    <!-- Hero & Quick Search Section with Complaint Themed Visuals -->
    <section class="bg-[#0a192f] text-white pt-10 pb-16 sm:pt-14 sm:pb-20 border-b border-slate-800 relative overflow-hidden">
        
        <!-- Subtle Glow Background Accents -->
        <div class="absolute top-0 right-1/4 w-96 h-96 bg-blue-600/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-0 left-10 w-80 h-80 bg-teal-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-8 items-center">
                
                <!-- Left Column: Official Announcement & Action -->
                <div class="lg:col-span-6 space-y-5 text-center lg:text-left">
                    
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-blue-500/15 text-blue-300 text-xs font-semibold border border-blue-400/30">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        <i class="fa-solid fa-bullhorn text-amber-400 text-xs"></i>
                        <span>Layanan Pengaduan & Sarpras SMKN 2 Karanganyar</span>
                    </div>

                    <h1 class="text-3xl sm:text-4xl lg:text-[42px] font-extrabold tracking-tight leading-tight text-white">
                        Pusat Layanan Pengaduan & Aspirasi Siswa SMKN 2 Karanganyar
                    </h1>

                    <p class="text-slate-300 text-xs sm:text-sm sm:leading-relaxed max-w-xl mx-auto lg:mx-0 font-normal">
                        Menemukan fasilitas rusak, kendala lab praktikum, kelistrikan bengkel, kebocoran air, atau aspirasi belajar di lingkungan sekolah? Sampaikan laporan pengaduan Anda di sini secara cepat, <strong>100% bebas login</strong>, dan dipantau progresnya menggunakan kode tiket resmi.
                    </p>

                    <!-- Primary Actions -->
                    <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-3 pt-1">
                        <a href="{{ route('pengaduan.create') }}" 
                           class="w-full sm:w-auto inline-flex items-center justify-center gap-2.5 px-6 py-3.5 rounded-xl font-bold text-xs sm:text-sm text-white bg-blue-600 hover:bg-blue-500 shadow-lg shadow-blue-600/30 transition active:scale-98">
                            <i class="fa-solid fa-pen-to-square text-sm"></i>
                            <span>Tulis Pengaduan Baru</span>
                        </a>

                        <a href="{{ route('pengaduan.history') }}" 
                           class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-3.5 rounded-xl font-semibold text-xs sm:text-sm text-white bg-white/10 hover:bg-white/15 border border-white/20 transition">
                            <i class="fa-solid fa-clock-rotate-left text-xs text-blue-300"></i>
                            <span>Riwayat Publik</span>
                        </a>

                        <a href="#alur-layanan" 
                           class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-4 py-3.5 rounded-xl font-semibold text-xs sm:text-sm text-slate-300 hover:text-white bg-transparent hover:bg-white/5 transition">
                            <i class="fa-solid fa-circle-question text-xs text-slate-400"></i>
                            <span>Alur Lapor</span>
                        </a>
                    </div>

                    <!-- Direct Ticket Search Box -->
                    <div class="pt-3 max-w-xl mx-auto lg:mx-0">
                        <div class="bg-white/5 backdrop-blur-md p-3.5 sm:p-4 rounded-2xl border border-white/15">
                            <label class="block text-xs font-semibold text-slate-200 mb-2 text-left flex items-center justify-between">
                                <span class="flex items-center gap-1.5">
                                    <i class="fa-solid fa-magnifying-glass text-blue-400"></i>
                                    <span>Lacak Status Tiket Pengaduan:</span>
                                </span>
                                <span class="text-[10px] text-slate-400 font-normal">Real-Time</span>
                            </label>
                            <form action="{{ route('pengaduan.track') }}" method="GET" class="relative flex items-center">
                                <input 
                                    type="text" 
                                    name="ticket" 
                                    placeholder="Masukkan Nomor Tiket (contoh: TKT-2026-0482)" 
                                    class="w-full pl-3.5 pr-28 py-2.5 rounded-xl bg-white text-slate-900 text-xs sm:text-sm font-semibold placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-inner"
                                    required
                                >
                                <button type="submit" class="absolute right-1 px-4 py-1.5 rounded-lg bg-blue-700 hover:bg-blue-600 text-white font-bold text-xs transition flex items-center gap-1.5">
                                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                                    <span>Lacak</span>
                                </button>
                            </form>
                            <div class="mt-2 text-[11px] text-slate-400 text-left flex items-center gap-1.5">
                                <i class="fa-solid fa-circle-info text-blue-400 text-[10px]"></i>
                                <span>Gunakan nomor tiket yang Anda terima setelah mengisi formulir pengaduan.</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Authentic School Service Desk Photography & Highlights -->
                <div class="lg:col-span-6">
                    <div class="relative max-w-lg mx-auto">
                        
                        <!-- Floating Badge 1 (Top Left) -->
                        <div class="absolute -top-3 -left-3 z-20 bg-white/95 backdrop-blur-md px-3.5 py-2 rounded-2xl shadow-xl border border-slate-200 flex items-center gap-2.5 hidden sm:flex">
                            <div class="w-8 h-8 rounded-xl bg-blue-100 text-blue-800 flex items-center justify-center text-sm font-bold">
                                <i class="fa-solid fa-headset"></i>
                            </div>
                            <div class="text-left">
                                <span class="text-[10px] uppercase font-bold tracking-wider text-slate-400 block">Loket Pelayanan</span>
                                <span class="text-xs font-extrabold text-slate-800 flex items-center gap-1">
                                    SMKN 2 Karanganyar
                                </span>
                            </div>
                        </div>

                        <!-- Main 2D Vector Illustration Container -->
                        <div class="rounded-3xl overflow-hidden bg-slate-800/60 p-2 sm:p-2.5 border border-white/20 shadow-2xl relative group">
                            <div class="overflow-hidden rounded-2xl bg-white shadow-inner relative">
                                <img 
                                    src="{{ asset('images/hero-pengaduan.webp') }}" 
                                    alt="Ilustrasi Layanan Pengaduan & Sarpras SMKN 2 Karanganyar" 
                                    class="w-full h-auto object-cover transform transition-transform duration-500 group-hover:scale-102"
                                >
                            </div>

                            <!-- Illustration Caption & Info Bar -->
                            <div class="pt-3 px-1 pb-1 text-center sm:text-left flex flex-col sm:flex-row items-center justify-between gap-2 text-xs text-slate-300">
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-school text-blue-400 text-xs"></i>
                                    <span class="font-medium text-slate-200 text-[11px] sm:text-xs">Pos Layanan Pengaduan & Sarana Prasarana SMKN 2 Karanganyar</span>
                                </div>
                                <span class="text-[10px] px-2.5 py-0.5 rounded-full bg-emerald-500/20 text-emerald-300 border border-emerald-400/30 font-bold uppercase tracking-wider flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span> SIADU Aktif
                                </span>
                            </div>
                        </div>

                        <!-- Floating Badge 2 (Bottom Right) -->
                        <div class="absolute -bottom-3 -right-3 z-20 bg-slate-900/95 backdrop-blur-md px-4 py-2.5 rounded-2xl shadow-xl border border-slate-700 flex items-center gap-3 hidden sm:flex">
                            <div class="w-8 h-8 rounded-xl bg-emerald-600 text-white flex items-center justify-center text-sm font-bold shadow-xs">
                                <i class="fa-solid fa-screwdriver-wrench"></i>
                            </div>
                            <div class="text-left">
                                <span class="text-[10px] uppercase font-bold tracking-wider text-slate-400 block">Tim Sarpras & Teknisi</span>
                                <span class="text-xs font-extrabold text-white">
                                    Respon Penanganan Cepat
                                </span>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Visual Feature Highlights: Why Report through SIADU? -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-6 sm:-mt-8 relative z-20">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            
            <div class="bg-white p-5 rounded-2xl border border-slate-200/90 shadow-md hover:shadow-lg transition flex items-start gap-4">
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center text-xl shrink-0 border border-blue-100">
                    <i class="fa-solid fa-lock-open"></i>
                </div>
                <div>
                    <h3 class="text-xs sm:text-sm font-bold text-slate-900 mb-1">100% Bebas Login</h3>
                    <p class="text-[11px] sm:text-xs text-slate-500 leading-relaxed">
                        Siswa, guru, dan wali murid dapat langsung melapor tanpa perlu registrasi akun.
                    </p>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-slate-200/90 shadow-md hover:shadow-lg transition flex items-start gap-4">
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center text-xl shrink-0 border border-emerald-100">
                    <i class="fa-solid fa-ticket"></i>
                </div>
                <div>
                    <h3 class="text-xs sm:text-sm font-bold text-slate-900 mb-1">Tiket Terlacak Real-Time</h3>
                    <p class="text-[11px] sm:text-xs text-slate-500 leading-relaxed">
                        Setiap aduan mendapatkan nomor tiket resmi untuk memantau proses verifikasi & perbaikan.
                    </p>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-slate-200/90 shadow-md hover:shadow-lg transition flex items-start gap-4">
                <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-700 flex items-center justify-center text-xl shrink-0 border border-purple-100">
                    <i class="fa-solid fa-user-secret"></i>
                </div>
                <div>
                    <h3 class="text-xs sm:text-sm font-bold text-slate-900 mb-1">Privasi & Opsi Anonim</h3>
                    <p class="text-[11px] sm:text-xs text-slate-500 leading-relaxed">
                        Kanal aman untuk keluhan sensitif, perundungan, atau rasa takut identitas diketahui.
                    </p>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-slate-200/90 shadow-md hover:shadow-lg transition flex items-start gap-4">
                <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center text-xl shrink-0 border border-amber-100">
                    <i class="fa-solid fa-camera-retro"></i>
                </div>
                <div>
                    <h3 class="text-xs sm:text-sm font-bold text-slate-900 mb-1">Bukti Foto Pengerjaan</h3>
                    <p class="text-[11px] sm:text-xs text-slate-500 leading-relaxed">
                        Teknisi melampirkan dokumentasi foto perbaikan fisik sebelum tiket dinyatakan tuntas.
                    </p>
                </div>
            </div>

        </div>
    </section>

    <!-- Departmental Categories Section: What can you report? -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center max-w-2xl mx-auto mb-12 space-y-2">
            <span class="text-xs font-bold text-blue-700 uppercase tracking-wider block">
                <i class="fa-solid fa-layer-group text-xs mr-1"></i> Klasifikasi Bidang Kerusakan & Keluhan
            </span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Apa Saja yang Dapat Anda Laporkan?</h2>
            <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
                Pilih jenis kendala yang Anda temukan di sekolah. Pengaduan akan otomatis diteruskan ke unit teknis penanggung jawab di SMKN 2 Karanganyar.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            
            <!-- Category 1: Sarana Prasarana -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs hover:border-blue-400 hover:shadow-md transition flex flex-col justify-between group">
                <div>
                    <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-700 flex items-center justify-center text-xl mb-4 group-hover:bg-blue-600 group-hover:text-white transition">
                        <i class="fa-solid fa-screwdriver-wrench"></i>
                    </div>
                    <span class="text-[10px] font-bold px-2 py-0.5 rounded bg-blue-100 text-blue-800 uppercase tracking-wider">
                        SLA Cepat 4 - 24 Jam
                    </span>
                    <h3 class="text-base font-bold text-slate-900 mt-2 mb-2">Sarana & Prasarana</h3>
                    <p class="text-xs text-slate-500 leading-relaxed mb-3">
                        Kelistrikan bengkel mesin, stopkontak korslet, sanitasi air & kran toilet, plafon bocor, mebeler meja/kursi rusak, pintu dan kunci ruang kelas.
                    </p>
                    <div class="text-[11px] text-slate-400">
                        <strong class="text-slate-600">Unit:</strong> Sarpras, Listrik, & Bangunan
                    </div>
                </div>
                <div class="pt-4 mt-4 border-t border-slate-100">
                    <a href="{{ route('pengaduan.create', ['kategori' => 'Sarana dan prasarana']) }}" 
                       class="text-xs font-bold text-blue-700 hover:text-blue-900 flex items-center justify-between group-hover:translate-x-1 transition-transform">
                        <span>Lapor Sarpras Ini</span>
                        <i class="fa-solid fa-arrow-right text-[11px]"></i>
                    </a>
                </div>
            </div>

            <!-- Category 2: Laboratorium & IT -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs hover:border-emerald-400 hover:shadow-md transition flex flex-col justify-between group">
                <div>
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-700 flex items-center justify-center text-xl mb-4 group-hover:bg-emerald-600 group-hover:text-white transition">
                        <i class="fa-solid fa-desktop"></i>
                    </div>
                    <span class="text-[10px] font-bold px-2 py-0.5 rounded bg-emerald-100 text-emerald-800 uppercase tracking-wider">
                        SLA 24 - 48 Jam
                    </span>
                    <h3 class="text-base font-bold text-slate-900 mt-2 mb-2">Lab Komputer & Jaringan IT</h3>
                    <p class="text-xs text-slate-500 leading-relaxed mb-3">
                        PC client lab RPL/TKJ mati, layar monitor blank, LCD proyektor ruang teori bergaris, kabel jaringan LAN, kendala login Wi-Fi sekolah, software praktik.
                    </p>
                    <div class="text-[11px] text-slate-400">
                        <strong class="text-slate-600">Unit:</strong> Laboratorium & Tim IT Sekolah
                    </div>
                </div>
                <div class="pt-4 mt-4 border-t border-slate-100">
                    <a href="{{ route('pengaduan.create', ['kategori' => 'Sarana dan prasarana']) }}" 
                       class="text-xs font-bold text-emerald-700 hover:text-emerald-900 flex items-center justify-between group-hover:translate-x-1 transition-transform">
                        <span>Lapor Kendala Lab/IT</span>
                        <i class="fa-solid fa-arrow-right text-[11px]"></i>
                    </a>
                </div>
            </div>

            <!-- Category 3: Perlindungan Siswa & BK -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs hover:border-purple-400 hover:shadow-md transition flex flex-col justify-between group">
                <div>
                    <div class="w-12 h-12 rounded-2xl bg-purple-50 text-purple-700 flex items-center justify-center text-xl mb-4 group-hover:bg-purple-600 group-hover:text-white transition">
                        <i class="fa-solid fa-hand-holding-heart"></i>
                    </div>
                    <span class="text-[10px] font-bold px-2 py-0.5 rounded bg-purple-100 text-purple-800 uppercase tracking-wider">
                        Kerahasiaan Tinggi
                    </span>
                    <h3 class="text-base font-bold text-slate-900 mt-2 mb-2">Perlindungan Kesiswaan</h3>
                    <p class="text-xs text-slate-500 leading-relaxed mb-3">
                        Laporan perundungan (bullying), intimidasi, kekerasan fisik/verbal, diskriminasi, pemalakan, serta kebutuhan konseling khusus siswa.
                    </p>
                    <div class="text-[11px] text-slate-400">
                        <strong class="text-slate-600">Unit:</strong> Satgas PPKS & Bimbingan Konseling (BK)
                    </div>
                </div>
                <div class="pt-4 mt-4 border-t border-slate-100">
                    <a href="{{ route('pengaduan.create', ['kategori' => 'Perlindungan kesiswaan (PPKS)']) }}" 
                       class="text-xs font-bold text-purple-700 hover:text-purple-900 flex items-center justify-between group-hover:translate-x-1 transition-transform">
                        <span>Lapor Secara Rahasia</span>
                        <i class="fa-solid fa-arrow-right text-[11px]"></i>
                    </a>
                </div>
            </div>

            <!-- Category 4: Administrasi & Akademik -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs hover:border-amber-400 hover:shadow-md transition flex flex-col justify-between group">
                <div>
                    <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-700 flex items-center justify-center text-xl mb-4 group-hover:bg-amber-600 group-hover:text-white transition">
                        <i class="fa-solid fa-file-invoice"></i>
                    </div>
                    <span class="text-[10px] font-bold px-2 py-0.5 rounded bg-amber-100 text-amber-800 uppercase tracking-wider">
                        SLA 1 - 3 Hari
                    </span>
                    <h3 class="text-base font-bold text-slate-900 mt-2 mb-2">Administrasi & Belajar</h3>
                    <p class="text-xs text-slate-500 leading-relaxed mb-3">
                        Pelayanan surat keterangan, administrasi PKL/magang industri, kendala presensi, buku perpustakaan, saran mutu pembelajaran.
                    </p>
                    <div class="text-[11px] text-slate-400">
                        <strong class="text-slate-600">Unit:</strong> Tata Usaha & Kurikulum
                    </div>
                </div>
                <div class="pt-4 mt-4 border-t border-slate-100">
                    <a href="{{ route('pengaduan.create', ['kategori' => 'Pembelajaran dan akademik']) }}" 
                       class="text-xs font-bold text-amber-700 hover:text-amber-900 flex items-center justify-between group-hover:translate-x-1 transition-transform">
                        <span>Lapor Administrasi</span>
                        <i class="fa-solid fa-arrow-right text-[11px]"></i>
                    </a>
                </div>
            </div>

        </div>
    </section>

    <!-- SOP & Workflow Steps Section: How the complaint is resolved -->
    <section id="alur-layanan" class="bg-slate-50 border-y border-slate-200 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-14 space-y-2">
                <span class="text-xs font-bold text-blue-700 uppercase tracking-wider block">
                    <i class="fa-solid fa-diagram-project text-xs mr-1"></i> Standar Operasional Prosedur
                </span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Alur Penanganan Pengaduan Sekolah</h2>
                <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
                    Setiap laporan diproses dengan cepat melalui 3 tahapan akuntabel untuk memastikan keluhan tuntas diperbaiki.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative">
                
                <!-- Step 1 -->
                <div class="bg-white p-7 rounded-2xl border border-slate-200 shadow-sm relative space-y-3">
                    <div class="flex items-center justify-between">
                        <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center text-xl font-bold">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </div>
                        <span class="text-3xl font-black text-slate-200">01</span>
                    </div>
                    <h3 class="text-base font-bold text-slate-900">Isi Form & Lampirkan Foto</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Pelapor menuliskan detail kerusakan, lokasi spesifik di lingkungan sekolah, dan melampirkan foto bukti. Nomor tiket unik terbit seketika.
                    </p>
                    <div class="pt-2 text-[11px] font-semibold text-blue-700 flex items-center gap-1.5">
                        <i class="fa-solid fa-circle-check text-emerald-600"></i>
                        <span>Bebas login & opsi pelapor rahasia/anonim</span>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="bg-white p-7 rounded-2xl border border-slate-200 shadow-sm relative space-y-3">
                    <div class="flex items-center justify-between">
                        <div class="w-12 h-12 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center text-xl font-bold">
                            <i class="fa-solid fa-user-gear"></i>
                        </div>
                        <span class="text-3xl font-black text-slate-200">02</span>
                    </div>
                    <h3 class="text-base font-bold text-slate-900">Verifikasi & Delegasi Teknisi</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Administrator memvalidasi aduan, menetapkan tingkat urgensi resmi (Normal, Mendesak, atau Bahaya), dan mendelegasikan teknisi unit penanggung jawab.
                    </p>
                    <div class="pt-2 text-[11px] font-semibold text-amber-700 flex items-center gap-1.5">
                        <i class="fa-solid fa-business-time text-amber-600"></i>
                        <span>Target SLA waktu penanganan ditetapkan</span>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="bg-white p-7 rounded-2xl border border-slate-200 shadow-sm relative space-y-3">
                    <div class="flex items-center justify-between">
                        <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-xl font-bold">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>
                        <span class="text-3xl font-black text-slate-200">03</span>
                    </div>
                    <h3 class="text-base font-bold text-slate-900">Tindakan Fisik & Tiket Selesai</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Teknisi melaksanakan inspeksi/perbaikan di lokasi, melampirkan foto hasil pengerjaan, dan admin mengesahkan tiket selesai untuk dinilai kepuasannya.
                    </p>
                    <div class="pt-2 text-[11px] font-semibold text-emerald-700 flex items-center gap-1.5">
                        <i class="fa-solid fa-star text-amber-500"></i>
                        <span>Pelapor dapat memberikan rating & ulasan</span>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Recent Public Complaints Section -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-8 gap-4 border-b border-slate-200 pb-4">
            <div>
                <span class="text-xs font-bold text-blue-700 uppercase tracking-wider block mb-1">
                    <i class="fa-solid fa-list-check mr-1"></i> Transparansi Tindak Lanjut
                </span>
                <h2 class="text-2xl font-extrabold text-slate-900">Perkembangan Laporan Terbaru</h2>
                <p class="text-xs text-slate-500 mt-1">Daftar aduan sarana prasarana sekolah yang sedang ditangani maupun telah tuntas diselesaikan.</p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('pengaduan.history') }}" class="text-xs font-bold text-blue-700 hover:text-blue-900 flex items-center gap-1.5 transition">
                    <span>Lihat Semua Riwayat ({{ $stats['total'] }})</span>
                    <i class="fa-solid fa-arrow-right text-[11px]"></i>
                </a>
                <span class="text-slate-300">|</span>
                <a href="{{ route('pengaduan.track') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800 flex items-center gap-1.5 transition">
                    <span>Lacak Tiket</span>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @forelse($recentReports as $report)
                <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs hover:border-slate-300 transition flex flex-col justify-between space-y-4">
                    <div>
                        <div class="flex items-center justify-between gap-2 mb-2">
                            <span class="font-mono text-xs font-bold text-blue-800">#{{ $report->ticket_number }}</span>
                            <x-status-badge :status="$report->status" />
                        </div>

                        <h3 class="font-bold text-sm text-slate-900 line-clamp-2 mb-1.5">
                            <a href="{{ route('pengaduan.track', ['ticket' => $report->ticket_number]) }}" class="hover:text-blue-700 transition">
                                {{ $report->judul }}
                            </a>
                        </h3>

                        <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed mb-3">
                            {{ $report->uraian }}
                        </p>

                        <div class="space-y-1.5 text-[11px] text-slate-600 border-t border-slate-100 pt-3">
                            <div class="flex items-center gap-1.5">
                                <span class="text-slate-400">Kategori:</span>
                                <span class="font-semibold text-slate-700">{{ $report->kategori }}</span>
                            </div>
                            @if($report->lokasi)
                                <div class="flex items-center gap-1.5">
                                    <span class="text-slate-400">Lokasi:</span>
                                    <span class="truncate font-medium text-slate-700">{{ $report->lokasi }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                        <span class="text-[11px] text-slate-400">
                            {{ $report->tanggal_lapor->translatedFormat('d M Y') }}
                        </span>
                        <a href="{{ route('pengaduan.track', ['ticket' => $report->ticket_number]) }}" 
                           class="font-bold text-blue-700 hover:text-blue-900 flex items-center gap-1">
                            Lihat Detail <i class="fa-solid fa-chevron-right text-[10px]"></i>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-1 md:col-span-2 lg:col-span-3 bg-white rounded-3xl p-10 text-center border border-slate-200 shadow-sm space-y-4">
                    <div class="w-16 h-16 rounded-2xl bg-blue-50 text-blue-600 mx-auto flex items-center justify-center text-2xl shadow-inner">
                        <i class="fa-solid fa-clipboard-check"></i>
                    </div>
                    <div class="max-w-md mx-auto space-y-1.5">
                        <h4 class="text-base font-bold text-slate-900">Seluruh Fasilitas Sekolah Terpantau Berfungsi Baik</h4>
                        <p class="text-xs text-slate-500 leading-relaxed">
                            Belum ada laporan pengaduan aktif saat ini. Menemukan kendala sarana, fasilitas lab, kelistrikan, atau kendala belajar di sekolah?
                        </p>
                    </div>
                    <div class="pt-1">
                        <a href="{{ route('pengaduan.create') }}" 
                           class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-blue-700 hover:bg-blue-600 text-white font-bold text-xs shadow-sm transition">
                            <i class="fa-solid fa-pen-to-square text-xs"></i>
                            <span>Tulis Pengaduan Pertama</span>
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        <div class="mt-8 text-center">
            <a href="{{ route('pengaduan.history') }}" 
               class="inline-flex items-center gap-2 px-6 py-3 rounded-xl border border-blue-200 bg-blue-50/70 hover:bg-blue-100 text-blue-800 text-xs font-bold transition shadow-xs">
                <i class="fa-solid fa-list-check text-xs"></i>
                <span>Buka Seluruh Riwayat Pengaduan Publik</span>
                <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
        </div>
    </section>

    <!-- Official School Notice Card with Hotline -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-14">
        <div class="bg-gradient-to-r from-[#0a192f] via-slate-900 to-[#0a192f] text-white rounded-3xl p-7 sm:p-10 border border-slate-800 shadow-xl flex flex-col md:flex-row items-center justify-between gap-6 relative overflow-hidden">
            
            <div class="space-y-2.5 max-w-2xl text-center md:text-left relative z-10">
                <span class="inline-flex items-center gap-1.5 text-[11px] font-bold uppercase tracking-wider text-amber-400 bg-amber-400/10 px-3 py-1 rounded-full border border-amber-400/20">
                    <i class="fa-solid fa-certificate text-xs"></i>
                    <span>Maklumat Pelayanan SMKN 2 Karanganyar</span>
                </span>
                <h3 class="text-xl sm:text-2xl font-bold">Menemukan Kendala Fasilitas yang Membahayakan?</h3>
                <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                    Untuk kejadian darurat seperti korsleting listrik aktif, pipa saluran jebol, atau insiden fisik, segera laporkan ke pos pelayanan atau tulis pengaduan dengan urgensi <em>Risiko Keselamatan</em> untuk penanganan dalam waktu kurang dari 4 jam.
                </p>
            </div>

            <div class="flex flex-col sm:flex-row items-center gap-3 shrink-0 relative z-10 w-full sm:w-auto">
                <a href="{{ route('pengaduan.create') }}" class="w-full sm:w-auto px-6 py-3 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-bold text-xs sm:text-sm transition shadow-sm text-center flex items-center justify-center gap-2">
                    <i class="fa-solid fa-pen-to-square"></i>
                    <span>Tulis Pengaduan Baru</span>
                </a>
                <a href="{{ route('login') }}" class="w-full sm:w-auto px-4 py-3 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 font-semibold text-xs sm:text-sm border border-slate-700 transition text-center flex items-center justify-center gap-2">
                    <i class="fa-solid fa-shield-halved text-xs text-blue-400"></i>
                    <span>Portal Masuk Admin</span>
                </a>
            </div>
        </div>
    </section>

</x-app-layout>
