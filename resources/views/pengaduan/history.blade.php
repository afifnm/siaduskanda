<x-app-layout>
    <x-slot:title>Riwayat Pengaduan Publik — SIADU SMKN 2 Karanganyar</x-slot:title>
    <x-slot:description>Daftar riwayat dan transparansi publik seluruh pengaduan sarana prasarana, fasilitas belajar, dan layanan di SMK Negeri 2 Karanganyar.</x-slot:description>

    <!-- Hero Header -->
    <section class="bg-[#0a192f] text-white pt-10 pb-12 sm:pt-12 sm:pb-16 border-b border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="space-y-4 max-w-3xl">
                <!-- Institutional Badge -->
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-md bg-white/10 text-slate-200 text-xs font-semibold border border-white/10">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>Transparansi & Akuntabilitas Publik</span>
                </div>

                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold tracking-tight text-white leading-tight">
                    Riwayat Pengaduan & Aspirasi Publik
                </h1>

                <p class="text-xs sm:text-sm text-slate-300 leading-relaxed font-normal">
                    Layanan keterbukaan informasi penanganan sarana prasarana, keluhan fasilitas belajar, dan aspirasi di SMK Negeri 2 Karanganyar. Siapapun dapat memantau perkembangan tindak lanjut tanpa perlu login.
                </p>

                <!-- Quick Action Buttons -->
                <div class="pt-2 flex flex-wrap items-center gap-3">
                    <a href="{{ route('pengaduan.create') }}" 
                       class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl font-bold text-xs text-white bg-blue-600 hover:bg-blue-500 shadow-sm transition active:scale-98">
                        <i class="fa-solid fa-pen-to-square text-xs"></i>
                        Tulis Pengaduan Baru
                    </a>
                    <a href="{{ route('pengaduan.track') }}" 
                       class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl font-semibold text-xs text-slate-300 hover:text-white bg-white/5 hover:bg-white/10 border border-white/15 transition">
                        <i class="fa-solid fa-magnifying-glass text-xs text-slate-400"></i>
                        Cari Nomor Tiket Spesifik
                    </a>
                </div>
            </div>

            <!-- KPI Counters Summary -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mt-8 pt-6 border-t border-slate-800">
                <div class="bg-white/5 backdrop-blur-xs p-4 rounded-xl border border-white/10">
                    <span class="text-[11px] text-slate-400 font-medium block mb-1">Total Riwayat Laporan</span>
                    <div class="text-2xl sm:text-3xl font-extrabold text-white">{{ $stats['total'] }}</div>
                    <span class="text-[10px] text-slate-400">Semua kategori aduan</span>
                </div>

                <div class="bg-emerald-950/40 p-4 rounded-xl border border-emerald-500/20">
                    <span class="text-[11px] text-emerald-300 font-medium block mb-1">Selesai Tuntas</span>
                    <div class="text-2xl sm:text-3xl font-extrabold text-emerald-400">{{ $stats['selesai'] }}</div>
                    <span class="text-[10px] text-emerald-300/80">Telah diverifikasi tuntas</span>
                </div>

                <div class="bg-blue-950/40 p-4 rounded-xl border border-blue-500/20">
                    <span class="text-[11px] text-blue-300 font-medium block mb-1">Sedang Ditangani</span>
                    <div class="text-2xl sm:text-3xl font-extrabold text-blue-400">{{ $stats['proses'] + $stats['terverifikasi'] }}</div>
                    <span class="text-[10px] text-blue-300/80">Oleh teknisi & unit kerja</span>
                </div>

                <div class="bg-amber-950/40 p-4 rounded-xl border border-amber-500/20">
                    <span class="text-[11px] text-amber-300 font-medium block mb-1">Antrean Verifikasi</span>
                    <div class="text-2xl sm:text-3xl font-extrabold text-amber-400">{{ $stats['masuk'] }}</div>
                    <span class="text-[10px] text-amber-300/80">Laporan baru masuk</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Container: Filter, Search & Feed -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full flex-1 space-y-6">

        <!-- Search & Filter Card -->
        <div class="bg-white rounded-2xl p-5 sm:p-6 border border-slate-200 shadow-xs space-y-4">
            
            <form action="{{ route('pengaduan.history') }}" method="GET" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-3.5">
                    
                    <!-- Search Input -->
                    <div class="md:col-span-5 relative">
                        <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wider mb-1">Pencarian Kata Kunci</label>
                        <div class="relative flex items-center">
                            <span class="absolute left-3.5 text-slate-400">
                                <i class="fa-solid fa-magnifying-glass text-xs"></i>
                            </span>
                            <input 
                                type="text" 
                                name="search" 
                                value="{{ $search }}" 
                                placeholder="Cari nomor tiket, judul masalah, atau lokasi..." 
                                class="w-full pl-10 pr-3.5 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm font-medium focus:ring-2 focus:ring-blue-600 focus:outline-none bg-white placeholder:text-slate-400"
                            >
                        </div>
                    </div>

                    <!-- Filter Kategori -->
                    <div class="md:col-span-3">
                        <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wider mb-1">Kategori Masalah</label>
                        <select 
                            name="kategori" 
                            class="w-full px-3 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm font-medium focus:ring-2 focus:ring-blue-600 focus:outline-none bg-white text-slate-800"
                        >
                            <option value="">Semua Kategori</option>
                            <option value="Sarana dan prasarana" {{ $kategori === 'Sarana dan prasarana' ? 'selected' : '' }}>Sarana & Prasarana</option>
                            <option value="Pembelajaran dan akademik" {{ $kategori === 'Pembelajaran dan akademik' ? 'selected' : '' }}>Fasilitas IT & Lab Komputer</option>
                            <option value="Perlindungan warga sekolah" {{ $kategori === 'Perlindungan warga sekolah' ? 'selected' : '' }}>Perlindungan Warga Sekolah</option>
                            <option value="Layanan administrasi" {{ $kategori === 'Layanan administrasi' ? 'selected' : '' }}>Administrasi & Kesiswaan</option>
                            <option value="Saran dan aspirasi" {{ $kategori === 'Saran dan aspirasi' ? 'selected' : '' }}>Saran & Aspirasi Mutu</option>
                        </select>
                    </div>

                    <!-- Filter Status -->
                    <div class="md:col-span-2">
                        <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wider mb-1">Status Penanganan</label>
                        <select 
                            name="status" 
                            class="w-full px-3 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm font-medium focus:ring-2 focus:ring-blue-600 focus:outline-none bg-white text-slate-800"
                        >
                            <option value="">Semua Status</option>
                            <option value="masuk" {{ $status === 'masuk' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                            <option value="terverifikasi" {{ $status === 'terverifikasi' ? 'selected' : '' }}>Terverifikasi</option>
                            <option value="dalam_proses" {{ $status === 'dalam_proses' ? 'selected' : '' }}>Sedang Ditangani</option>
                            <option value="menunggu_konfirmasi" {{ $status === 'menunggu_konfirmasi' ? 'selected' : '' }}>Menunggu Review</option>
                            <option value="selesai" {{ $status === 'selesai' ? 'selected' : '' }}>Selesai Tuntas</option>
                        </select>
                    </div>

                    <!-- Sort Order -->
                    <div class="md:col-span-2">
                        <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wider mb-1">Urutan</label>
                        <select 
                            name="sort" 
                            class="w-full px-3 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm font-medium focus:ring-2 focus:ring-blue-600 focus:outline-none bg-white text-slate-800"
                        >
                            <option value="latest" {{ $sortBy === 'latest' ? 'selected' : '' }}>Terbaru</option>
                            <option value="oldest" {{ $sortBy === 'oldest' ? 'selected' : '' }}>Terlama</option>
                            <option value="urgensi" {{ $sortBy === 'urgensi' ? 'selected' : '' }}>Urgensi Tertinggi</option>
                        </select>
                    </div>

                </div>

                <!-- Form Controls: Submit & Reset -->
                <div class="flex flex-wrap items-center justify-between gap-3 pt-2 border-t border-slate-100 text-xs">
                    <!-- Fast Filter Pills -->
                    <div class="flex flex-wrap items-center gap-1.5">
                        <span class="text-slate-400 font-medium">Filter cepat:</span>
                        <a href="{{ route('pengaduan.history') }}" 
                           class="px-2.5 py-1 rounded-lg transition font-semibold {{ empty($status) && empty($kategori) ? 'bg-blue-100 text-blue-900 border border-blue-200' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                            Semua ({{ $stats['total'] }})
                        </a>
                        <a href="{{ route('pengaduan.history', ['status' => 'dalam_proses']) }}" 
                           class="px-2.5 py-1 rounded-lg transition font-semibold {{ $status === 'dalam_proses' ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                            Sedang Diproses ({{ $stats['proses'] }})
                        </a>
                        <a href="{{ route('pengaduan.history', ['status' => 'selesai']) }}" 
                           class="px-2.5 py-1 rounded-lg transition font-semibold {{ $status === 'selesai' ? 'bg-emerald-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                            Selesai ({{ $stats['selesai'] }})
                        </a>
                        <a href="{{ route('pengaduan.history', ['status' => 'masuk']) }}" 
                           class="px-2.5 py-1 rounded-lg transition font-semibold {{ $status === 'masuk' ? 'bg-amber-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                            Antrean Baru ({{ $stats['masuk'] }})
                        </a>
                    </div>

                    <div class="flex items-center gap-2 ml-auto">
                        @if($search || $status || $kategori || $sortBy !== 'latest')
                            <a href="{{ route('pengaduan.history') }}" class="px-3 py-2 rounded-xl text-slate-500 hover:text-slate-800 font-semibold transition">
                                <i class="fa-solid fa-rotate-left mr-1"></i> Reset
                            </a>
                        @endif
                        <button type="submit" class="px-4 py-2 rounded-xl bg-blue-700 hover:bg-blue-800 text-white font-bold transition shadow-xs flex items-center gap-1.5">
                            <i class="fa-solid fa-filter text-xs"></i> Terapkan Filter
                        </button>
                    </div>
                </div>

            </form>

        </div>

        <!-- Result Metadata Counter -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 text-xs text-slate-500 px-1">
            <div>
                Menampilkan <strong class="text-slate-800">{{ $pengaduans->firstItem() ?? 0 }} - {{ $pengaduans->lastItem() ?? 0 }}</strong> dari total <strong class="text-slate-800">{{ $pengaduans->total() }}</strong> laporan pengaduan publik.
            </div>
            @if($search)
                <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-amber-50 text-amber-900 border border-amber-200 text-xs">
                    <i class="fa-solid fa-magnifying-glass text-[10px]"></i>
                    <span>Hasil pencarian: <strong>"{{ $search }}"</strong></span>
                </div>
            @endif
        </div>

        <!-- Complaint Cards Feed -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @forelse($pengaduans as $pengaduan)
                <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs hover:border-slate-300 hover:shadow-sm transition flex flex-col justify-between space-y-4">
                    
                    <div class="space-y-3">
                        <!-- Top Meta Row -->
                        <div class="flex items-center justify-between gap-2">
                            <a href="{{ route('pengaduan.track', ['ticket' => $pengaduan->ticket_number]) }}" 
                               class="font-mono text-xs font-black text-blue-900 hover:text-blue-700 bg-blue-50/80 px-2 py-0.5 rounded border border-blue-200/80 transition">
                                #{{ $pengaduan->ticket_number }}
                            </a>
                            <div class="flex items-center gap-1.5">
                                <x-status-badge :status="$pengaduan->status" />
                            </div>
                        </div>

                        <!-- Title -->
                        <h3 class="font-bold text-sm text-slate-900 line-clamp-2 leading-snug">
                            <a href="{{ route('pengaduan.track', ['ticket' => $pengaduan->ticket_number]) }}" 
                               class="hover:text-blue-700 transition">
                                {{ $pengaduan->judul }}
                            </a>
                        </h3>

                        <!-- Description Snippet -->
                        <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">
                            {{ $pengaduan->uraian }}
                        </p>

                        <!-- Attached Photo Thumbnail (If any) -->
                        @if($pengaduan->bukti_pelapor_url || $pengaduan->bukti_petugas_url)
                            <div class="pt-1">
                                <a href="{{ route('pengaduan.track', ['ticket' => $pengaduan->ticket_number]) }}" class="block relative group rounded-xl overflow-hidden border border-slate-200 h-28 bg-slate-100">
                                    <img 
                                        src="{{ $pengaduan->bukti_petugas_url ?? $pengaduan->bukti_pelapor_url }}" 
                                        alt="Foto Bukti" 
                                        class="w-full h-full object-cover group-hover:scale-102 transition duration-200"
                                        loading="lazy"
                                    >
                                    <div class="absolute bottom-2 left-2 px-2 py-0.5 rounded bg-slate-900/80 text-white text-[10px] font-semibold flex items-center gap-1">
                                        <i class="fa-solid fa-camera"></i>
                                        <span>{{ $pengaduan->bukti_petugas_url ? 'Dokumentasi Selesai' : 'Foto Kejadian' }}</span>
                                    </div>
                                </a>
                            </div>
                        @endif

                        <!-- Metadata Badges -->
                        <div class="space-y-1.5 text-[11px] text-slate-600 border-t border-slate-100 pt-3">
                            <div class="flex items-center gap-1.5">
                                <i class="fa-solid fa-tag text-slate-400 w-3.5 text-center"></i>
                                <span class="text-slate-400">Kategori:</span>
                                <span class="font-semibold text-slate-700 truncate">{{ $pengaduan->kategori }}</span>
                            </div>

                            @if($pengaduan->lokasi)
                                <div class="flex items-center gap-1.5">
                                    <i class="fa-solid fa-location-dot text-slate-400 w-3.5 text-center"></i>
                                    <span class="text-slate-400">Lokasi:</span>
                                    <span class="font-medium text-slate-700 truncate">{{ $pengaduan->lokasi }}</span>
                                </div>
                            @endif

                            <div class="flex items-center gap-1.5">
                                <i class="fa-solid fa-user text-slate-400 w-3.5 text-center"></i>
                                <span class="text-slate-400">Pelapor:</span>
                                @if($pengaduan->is_anonim)
                                    <span class="font-semibold text-slate-500 italic flex items-center gap-1">
                                        <i class="fa-solid fa-user-secret text-[10px]"></i> Pelapor Anonim
                                    </span>
                                @else
                                    <span class="font-semibold text-slate-700 truncate">
                                        {{ $pengaduan->nama_pelapor }} ({{ $pengaduan->jenis_pelapor }})
                                    </span>
                                @endif
                            </div>

                            <!-- Assignment Status -->
                            @if($pengaduan->nama_petugas)
                                <div class="flex items-center gap-1.5">
                                    <i class="fa-solid fa-wrench text-emerald-600 w-3.5 text-center"></i>
                                    <span class="text-slate-400">Teknisi:</span>
                                    <span class="font-semibold text-emerald-800 truncate">{{ $pengaduan->nama_petugas }}</span>
                                </div>
                            @endif

                            <!-- Completed Satisfaction Rating (If any) -->
                            @if($pengaduan->status === 'selesai' && $pengaduan->rating)
                                <div class="flex items-center gap-1 text-amber-500 font-bold pt-0.5">
                                    <i class="fa-solid fa-star text-[11px]"></i>
                                    <span class="text-slate-700 text-[11px]">{{ $pengaduan->rating }} / 5 Bintang Kepuasan</span>
                                </div>
                            @endif
                        </div>

                    </div>

                    <!-- Card Footer Actions -->
                    <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                        <span class="text-[11px] text-slate-400 flex items-center gap-1">
                            <i class="fa-regular fa-clock text-[10px]"></i>
                            {{ $pengaduan->tanggal_lapor->translatedFormat('d M Y') }}
                        </span>

                        <a href="{{ route('pengaduan.track', ['ticket' => $pengaduan->ticket_number]) }}" 
                           class="inline-flex items-center gap-1 font-bold text-blue-700 hover:text-blue-900 group">
                            <span>Lacak & Riwayat</span>
                            <i class="fa-solid fa-arrow-right text-[10px] group-hover:translate-x-0.5 transition-transform"></i>
                        </a>
                    </div>

                </div>
            @empty
                <div class="col-span-full bg-white rounded-2xl p-12 text-center border border-slate-200 space-y-3.5">
                    <div class="w-14 h-14 rounded-full bg-slate-100 text-slate-400 mx-auto flex items-center justify-center text-xl font-bold">
                        <i class="fa-solid fa-inbox"></i>
                    </div>
                    <h3 class="text-base font-bold text-slate-900">Tidak Ada Laporan yang Cocok</h3>
                    <p class="text-xs text-slate-500 max-w-md mx-auto leading-relaxed">
                        Tidak ditemukan data pengaduan yang sesuai dengan kriteria pencarian atau filter yang Anda terapkan.
                    </p>
                    <div class="pt-2 flex flex-wrap items-center justify-center gap-2">
                        <a href="{{ route('pengaduan.history') }}" class="px-4 py-2 rounded-xl bg-slate-100 text-slate-700 font-bold text-xs hover:bg-slate-200 transition">
                            Hapus Semua Filter
                        </a>
                        <a href="{{ route('pengaduan.create') }}" class="px-4 py-2 rounded-xl bg-blue-700 text-white font-bold text-xs hover:bg-blue-800 transition">
                            Tulis Pengaduan Baru
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($pengaduans->hasPages())
            <div class="pt-4 flex justify-center">
                {{ $pengaduans->links() }}
            </div>
        @endif

        <!-- Public Policy & Privacy Guarantee -->
        <div class="bg-slate-50 rounded-2xl p-6 border border-slate-200 text-xs text-slate-600 space-y-2">
            <h4 class="font-bold text-slate-800 flex items-center gap-2 uppercase tracking-wider text-[11px]">
                <i class="fa-solid fa-shield-halved text-blue-700"></i> Ketentuan Transparansi & Perlindungan Data SIADU SMKN 2 Karanganyar
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-1 leading-relaxed text-slate-600">
                <div>
                    <strong class="text-slate-800 block mb-0.5">1. Tanpa Kewajiban Akun</strong>
                    <span>Seluruh siswa, guru, staf, maupun orang tua murid dapat menyampaikan laporan dan melihat riwayat tanpa perlu membuat akun atau login.</span>
                </div>
                <div>
                    <strong class="text-slate-800 block mb-0.5">2. Perlindungan Privasi</strong>
                    <span>Nomor telepon dan kontak pribadi pelapor tidak dipublikasikan ke publik. Laporan dengan opsi anonim dirahasiakan identitasnya.</span>
                </div>
                <div>
                    <strong class="text-slate-800 block mb-0.5">3. Akuntabilitas & Solusi</strong>
                    <span>Setiap perkembangan tindakan teknisi dan perbaikan fisik dicatat secara kronologis dalam sistem audit trail demi peningkatan fasilitas sekolah.</span>
                </div>
            </div>
        </div>

    </main>

</x-app-layout>
