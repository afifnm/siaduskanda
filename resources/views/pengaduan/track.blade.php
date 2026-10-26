<x-app-layout>
    <x-slot:title>Lacak Pengaduan — SIADU SMKN 2 Karanganyar</x-slot:title>

    <!-- Sub Header Search Section with Thematic Illustration -->
    <div class="bg-[#0a192f] text-white py-12 border-b border-slate-800 relative overflow-hidden">
        <div class="max-w-5xl mx-auto px-4 sm:px-6">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-center">
                
                <!-- Left: Digital Ticket Badge & Live Scanner UI (Pure Modern UI) -->
                <div class="md:col-span-4">
                    <div class="max-w-[260px] mx-auto bg-gradient-to-br from-slate-900 to-slate-950 p-4 rounded-2xl border border-white/15 shadow-2xl relative overflow-hidden text-left">
                        <div class="flex items-center justify-between pb-3 border-b border-white/10">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-lg bg-blue-600/30 border border-blue-400/40 text-blue-400 flex items-center justify-center text-xs">
                                    <i class="fa-solid fa-ticket"></i>
                                </div>
                                <span class="text-[11px] font-bold text-white tracking-wide">TIKET RESMI</span>
                            </div>
                            <span class="text-[10px] px-2 py-0.5 rounded-full bg-emerald-500/20 text-emerald-300 font-bold border border-emerald-500/30 flex items-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span> AKTIF
                            </span>
                        </div>
                        <div class="py-3 space-y-1.5">
                            <span class="text-[10px] uppercase font-semibold text-slate-400 block tracking-wider">Format Kode Tiket</span>
                            <div class="font-mono text-sm font-extrabold text-blue-300 tracking-wider bg-white/5 px-2.5 py-1.5 rounded-lg border border-white/10 flex items-center justify-between">
                                <span>TKT-2026-XXXX</span>
                                <i class="fa-solid fa-barcode text-slate-400 text-sm"></i>
                            </div>
                            <p class="text-[10.5px] text-slate-300 leading-relaxed pt-1">
                                Pantau verifikasi & tindak lanjut perbaikan sarana SMKN 2 Karanganyar.
                            </p>
                        </div>
                        <div class="pt-2 border-t border-white/10 flex items-center justify-between text-[10px] text-slate-400">
                            <span>Sistem SIADU</span>
                            <span class="text-amber-400 font-semibold flex items-center gap-1">
                                <i class="fa-solid fa-shield-halved text-[10px]"></i> Terverifikasi
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Right: Text & Form -->
                <div class="md:col-span-8 space-y-3.5 text-center md:text-left">
                    <div class="inline-flex items-center gap-1.5 text-[11px] font-bold uppercase tracking-wider text-amber-400 bg-white/5 px-2.5 py-1 rounded-full border border-white/10">
                        <i class="fa-solid fa-magnifying-glass text-[10px]"></i>
                        <span>Pusat Pelacakan Berkas Pengaduan</span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-white">Lacak Status & Progres Tiket Pengaduan</h1>
                    <p class="text-xs sm:text-sm text-slate-300 font-normal leading-relaxed max-w-xl">
                        Ketikkan nomor tiket yang Anda dapatkan saat pelaporan untuk memantau proses verifikasi, penugasan teknisi, dan dokumentasi foto hasil pengerjaan.
                    </p>

                    <!-- Search Form -->
                    <form action="{{ route('pengaduan.track') }}" method="GET" class="pt-1 max-w-lg">
                        <div class="relative flex items-center">
                            <span class="absolute left-3.5 text-slate-400">
                                <i class="fa-solid fa-ticket text-xs"></i>
                            </span>
                            <input 
                                type="text" 
                                name="ticket" 
                                value="{{ $ticketQuery }}" 
                                placeholder="Contoh: TKT-2026-0482" 
                                class="w-full pl-10 pr-28 py-3 rounded-xl bg-white text-slate-800 text-xs sm:text-sm font-semibold placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-600 shadow-md"
                                required
                            >
                            <button type="submit" class="absolute right-1.5 px-4 py-2 rounded-lg bg-blue-700 hover:bg-blue-600 text-white font-bold text-xs transition flex items-center gap-1.5 shadow-sm">
                                <i class="fa-solid fa-magnifying-glass text-xs"></i>
                                <span>Lacak Tiket</span>
                            </button>
                        </div>
                    </form>

                    <div class="flex items-center justify-center md:justify-start gap-4 text-[11px] text-slate-400 pt-0.5">
                        <span class="flex items-center gap-1"><i class="fa-solid fa-check text-emerald-400"></i> Bebas Login</span>
                        <span class="text-slate-600">•</span>
                        <span class="flex items-center gap-1"><i class="fa-solid fa-clock text-blue-400"></i> Update Real-Time</span>
                        <span class="text-slate-600">•</span>
                        <span class="flex items-center gap-1"><i class="fa-solid fa-image text-amber-400"></i> Foto Bukti Perbaikan</span>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Main Results Container -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full flex-1">

        @if($ticketNotFound)
            <!-- Ticket Not Found Alert -->
            <div class="max-w-lg mx-auto bg-white rounded-2xl p-8 border border-slate-200 shadow-sm text-center space-y-3.5 my-8">
                <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-500 mx-auto flex items-center justify-center text-xl font-bold">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>
                <h2 class="text-base font-bold text-slate-900">Nomor Tiket Tidak Ditemukan</h2>
                <p class="text-xs text-slate-500 leading-relaxed">
                    Nomor tiket <strong class="text-slate-800 font-mono">"{{ $ticketQuery }}"</strong> tidak tercatat di pangkalan data SIADU SMKN 2 Karanganyar. Mohon pastikan ejaan kode tiket sudah sesuai.
                </p>
                <div class="pt-2">
                    <a href="{{ route('pengaduan.track', ['ticket' => 'TKT-2026-0482']) }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-blue-50 text-blue-800 font-bold text-xs hover:bg-blue-100 transition border border-blue-200">
                        Buka Tiket Sampel Uji Coba (#TKT-2026-0482)
                    </a>
                </div>
            </div>
        @elseif($ticketData)
            <div class="mb-4 flex items-center justify-between gap-3 text-xs">
                <a href="{{ route('pengaduan.history') }}" class="font-semibold text-blue-700 hover:text-blue-900 inline-flex items-center gap-1.5 transition">
                    <i class="fa-solid fa-arrow-left text-[11px]"></i>
                    <span>Kembali ke Riwayat Pengaduan Publik</span>
                </a>
                <span class="text-slate-400 hidden sm:inline text-[11px]">
                    <i class="fa-solid fa-globe mr-1 text-slate-400"></i> Informasi riwayat penanganan ini dapat diakses publik
                </span>
            </div>

            <div class="space-y-6">

                <!-- Header Card Status -->
                <div class="bg-white rounded-2xl p-6 sm:p-7 border border-slate-200 shadow-sm">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-slate-200">
                        <div>
                            <div class="flex flex-wrap items-center gap-2 mb-2">
                                <span class="font-mono text-xl sm:text-2xl font-black text-blue-900">#{{ $ticketData->ticket_number }}</span>
                                <x-status-badge :status="$ticketData->status" />
                            </div>
                            <h2 class="text-lg sm:text-xl font-extrabold text-slate-900">{{ $ticketData->judul }}</h2>
                            <div class="flex flex-wrap items-center gap-y-1 gap-x-3 text-xs text-slate-500 mt-2">
                                <span class="flex items-center gap-1.5">
                                    <i class="fa-regular fa-clock text-slate-400"></i> Dilaporkan: <strong class="text-slate-700">{{ $ticketData->tanggal_lapor->translatedFormat('d F Y, H:i') }} WIB</strong>
                                </span>
                                <span>•</span>
                                <span class="flex items-center gap-1.5">
                                    <i class="fa-solid fa-location-dot text-slate-400"></i> Lokasi: <strong class="text-slate-700">{{ $ticketData->lokasi ?? 'Area Sekolah' }}</strong>
                                </span>
                                <span>•</span>
                                <span class="flex items-center gap-1.5">
                                    <i class="fa-solid fa-user text-slate-400"></i> Pelapor: <strong class="text-slate-700">{{ $ticketData->is_anonim ? 'Pelapor Anonim' : $ticketData->nama_pelapor }}</strong>
                                </span>
                            </div>
                        </div>

                        <!-- Priority Badge Box -->
                        <div class="sm:text-right shrink-0">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Tingkat Urgensi:</span>
                            <x-urgency-badge :urgensi="$ticketData->effective_urgensi" />
                        </div>
                    </div>

                    <!-- 5-Step Stepper Progress Bar -->
                    <x-stepper :status="$ticketData->status" :stepIndex="$ticketData->step_index" />
                </div>

                <!-- 2 Columns Grid: Detail Aduan vs Hasil Tindak Lanjut -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

                    <!-- Left Column (Detail Laporan Awal & Riwayat) -->
                    <div class="lg:col-span-5 space-y-6">
                        
                        <!-- Rincian Laporan -->
                        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs space-y-4">
                            <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2 border-b border-slate-100 pb-3">
                                <i class="fa-solid fa-file-lines text-blue-700"></i> Rincian Pengaduan Awal
                            </h3>

                            <div class="space-y-3.5 text-xs">
                                <div>
                                    <span class="text-slate-400 block mb-0.5 font-medium">Kategori Masalah:</span>
                                    <span class="font-bold text-slate-800 text-sm">{{ $ticketData->kategori }}</span>
                                </div>
                                <div>
                                    <span class="text-slate-400 block mb-0.5 font-medium">Jenis Pelapor:</span>
                                    <span class="font-semibold text-slate-800">{{ $ticketData->jenis_pelapor }}</span>
                                </div>
                                <div>
                                    <span class="text-slate-400 block mb-0.5 font-medium">Lokasi Spesifik:</span>
                                    <span class="font-semibold text-slate-800">{{ $ticketData->lokasi ?? 'Area Sekolah SMKN 2' }}</span>
                                </div>
                                <div>
                                    <span class="text-slate-400 block mb-0.5 font-medium">Deskripsi Lengkap:</span>
                                    <p class="p-3.5 bg-slate-50 rounded-xl border border-slate-200/80 text-slate-700 leading-relaxed font-normal">
                                        {{ $ticketData->uraian }}
                                    </p>
                                </div>

                                <!-- Foto Bukti dari Pelapor -->
                                @if($ticketData->bukti_pelapor_url)
                                    <div>
                                        <span class="text-slate-400 block mb-1 font-medium">Bukti Foto dari Pelapor:</span>
                                        <a href="{{ $ticketData->bukti_pelapor_url }}" target="_blank" class="block relative group overflow-hidden rounded-xl border border-slate-200">
                                            <img src="{{ $ticketData->bukti_pelapor_url }}" alt="Bukti Pelapor" class="w-full h-40 object-cover group-hover:scale-102 transition duration-200">
                                            <div class="absolute inset-0 bg-slate-900/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center text-white text-xs font-semibold gap-1.5">
                                                <i class="fa-solid fa-magnifying-glass-plus"></i> Klik untuk perbesar
                                            </div>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Timeline Riwayat Status (Audit Trail) -->
                        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs space-y-4">
                            <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2 border-b border-slate-100 pb-3">
                                <i class="fa-solid fa-clock-rotate-left text-blue-700"></i> Riwayat Perkembangan Penanganan
                            </h3>

                            <div class="space-y-4">
                                @forelse($ticketData->histories as $history)
                                    <div class="relative pl-5 pb-2 border-l-2 border-slate-200 last:border-transparent">
                                        <div class="absolute -left-[5px] top-0.5 w-2 h-2 rounded-full bg-blue-700"></div>
                                        <div class="flex items-center justify-between text-[11px] mb-0.5">
                                            <span class="font-bold text-slate-900">{{ $history->action_title }}</span>
                                            <span class="text-slate-400">{{ $history->created_at->translatedFormat('d M H:i') }}</span>
                                        </div>
                                        <span class="text-[11px] text-slate-500 font-medium block">Oleh: {{ $history->actor_name }}</span>
                                        @if($history->notes)
                                            <p class="text-xs text-slate-600 mt-1.5 bg-slate-50 p-2.5 rounded-lg border border-slate-200/80 leading-relaxed">
                                                {{ $history->notes }}
                                            </p>
                                        @endif
                                    </div>
                                @empty
                                    <p class="text-xs text-slate-400">Belum ada riwayat aktivitas.</p>
                                @endforelse
                            </div>
                        </div>

                        <!-- Pos Piket SMKN 2 Kra -->
                        <div class="bg-[#0a192f] text-white rounded-2xl p-5 border border-slate-800 space-y-2.5">
                            <h4 class="font-bold text-xs uppercase tracking-wider text-slate-200 flex items-center gap-2">
                                <i class="fa-solid fa-headset text-amber-400"></i> Bantuan & Layanan Cepat
                            </h4>
                            <p class="text-xs text-slate-300 leading-relaxed">
                                Terdapat situasi yang membutuhkan respons segera? Anda dapat berkoordinasi langsung dengan staf pos piket SMKN 2 Karanganyar.
                            </p>
                            <div class="text-xs text-slate-300 pt-2 border-t border-white/10 space-y-1">
                                <p><i class="fa-solid fa-phone text-blue-400 mr-2"></i> Pos Piket: (0271) 494549</p>
                                <p><i class="fa-solid fa-location-dot text-amber-400 mr-2"></i> Gedung Kantor Utama Lantai 1</p>
                            </div>
                        </div>

                    </div>

                    <!-- Right Column (Hasil Tindak Lanjut & Bukti Pengerjaan) -->
                    <div class="lg:col-span-7 space-y-6">

                        <!-- Card Hasil Tindak Lanjut -->
                        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs space-y-5">
                            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                                <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                                    <i class="fa-solid fa-clipboard-check text-emerald-700"></i> Hasil Tindak Lanjut Unit
                                </h3>
                                <span class="text-xs font-semibold text-slate-600">
                                    {{ $ticketData->unit_tujuan ? $ticketData->unit_tujuan : 'Menunggu Penugasan' }}
                                </span>
                            </div>

                            @if(!$ticketData->petugas_id && !$ticketData->nama_petugas)
                                <!-- Case 1: Belum ada petugas -->
                                <div class="bg-slate-50 rounded-xl p-8 text-center border border-slate-200 space-y-2">
                                    <i class="fa-regular fa-clock text-amber-600 text-2xl mb-1"></i>
                                    <h4 class="font-bold text-sm text-slate-800">Menunggu Verifikasi & Delegasi Unit</h4>
                                    <p class="text-xs text-slate-500 max-w-md mx-auto">Verifikator admin sekolah sedang memeriksa laporan Anda dan segera menugaskan teknisi pelaksana lapangan.</p>
                                </div>
                            @else
                                <!-- Case 2: Petugas Sudah Ditugaskan -->
                                <div class="space-y-4">
                                    <!-- Petugas Info Banner -->
                                    <div class="flex items-center gap-3 p-3.5 bg-slate-50 rounded-xl border border-slate-200">
                                        <div class="w-9 h-9 rounded-lg bg-blue-700 text-white flex items-center justify-center font-bold text-xs shrink-0">
                                            <i class="fa-solid fa-user-gear"></i>
                                        </div>
                                        <div>
                                            <span class="text-[10px] text-slate-500 font-bold block uppercase tracking-wider">Petugas Penanggung Jawab</span>
                                            <span class="text-xs sm:text-sm font-bold text-slate-900">{{ $ticketData->nama_petugas }}</span>
                                        </div>
                                        <div class="ml-auto text-right text-xs">
                                            <span class="text-slate-400 block text-[10px]">Target Selesai:</span>
                                            <span class="font-bold text-slate-800">{{ $ticketData->deadline ? $ticketData->deadline->translatedFormat('d M H:i') : 'Sesuai SOP SLA' }}</span>
                                        </div>
                                    </div>

                                    <!-- Catatan Tindakan Petugas -->
                                    <div>
                                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Catatan Tindakan Teknis / Solusi:</label>
                                        <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/90 text-xs sm:text-sm text-slate-800 leading-relaxed">
                                            {{ $ticketData->catatan_petugas ?: 'Teknisi sedang melaksanakan pemeriksaan fisik dan investigasi teknis di lokasi.' }}
                                        </div>
                                    </div>

                                    @if($ticketData->suku_cadang)
                                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-800 flex items-center gap-2 font-medium">
                                            <i class="fa-solid fa-toolbox text-slate-500"></i>
                                            <span><strong>Material / Komponen:</strong> {{ $ticketData->suku_cadang }}</span>
                                        </div>
                                    @endif

                                    <!-- Before / After Photo Comparison -->
                                    <div>
                                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Dokumentasi Bukti Lapangan:</label>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                                            
                                            <!-- Before / Pelaporan -->
                                            <div class="space-y-1">
                                                <span class="text-[11px] font-semibold text-slate-600 flex items-center gap-1.5">
                                                    <span class="w-2 h-2 rounded-full bg-slate-400"></span> Kondisi Sebelum / Pelaporan:
                                                </span>
                                                <div class="rounded-xl overflow-hidden border border-slate-200 h-36 bg-slate-100 flex items-center justify-center">
                                                    @if($ticketData->bukti_pelapor_url)
                                                        <img src="{{ $ticketData->bukti_pelapor_url }}" alt="Sebelum" class="w-full h-full object-cover">
                                                    @else
                                                        <span class="text-xs text-slate-400 italic">Tidak ada foto awal</span>
                                                    @endif
                                                </div>
                                            </div>

                                            <!-- After / Hasil Tindakan -->
                                            <div class="space-y-1">
                                                <span class="text-[11px] font-semibold text-emerald-700 flex items-center gap-1.5">
                                                    <span class="w-2 h-2 rounded-full bg-emerald-600"></span> Kondisi Sesudah Penanganan:
                                                </span>
                                                <div class="rounded-xl overflow-hidden border border-slate-200 h-36 bg-slate-100 flex items-center justify-center">
                                                    @if($ticketData->bukti_petugas_url)
                                                        <img src="{{ $ticketData->bukti_petugas_url }}" alt="Sesudah" class="w-full h-full object-cover">
                                                    @else
                                                        <span class="text-xs text-slate-400 italic">Belum ada foto pengerjaan</span>
                                                    @endif
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <!-- Catatan Verifikasi Admin -->
                                    @if($ticketData->admin_close_feedback)
                                        <div class="p-3.5 rounded-xl bg-emerald-50 border border-emerald-200 text-xs">
                                            <span class="font-bold text-emerald-900 block mb-0.5">
                                                <i class="fa-solid fa-circle-check text-emerald-700 mr-1"></i> Pengesahan Penutupan Resmi Admin Sekolah:
                                            </span>
                                            <p class="text-emerald-800 leading-relaxed">{{ $ticketData->admin_close_feedback }}</p>
                                        </div>
                                    @elseif($ticketData->catatan_admin)
                                        <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200 text-xs">
                                            <span class="font-bold text-slate-800 block mb-0.5">
                                                <i class="fa-solid fa-circle-info text-blue-700 mr-1"></i> Arahan Verifikator Admin:
                                            </span>
                                            <p class="text-slate-700">{{ $ticketData->catatan_admin }}</p>
                                        </div>
                                    @endif

                                </div>
                            @endif
                        </div>

                        <!-- Card Feedback & Rating Pelapor (Jika status Selesai) -->
                        @if($ticketData->status === 'selesai')
                            <div class="bg-white rounded-2xl p-6 border border-emerald-200 shadow-xs space-y-4" x-data="{ rating: {{ $ticketData->rating ?? 5 }} }">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-lg bg-emerald-100 text-emerald-800 flex items-center justify-center font-bold text-base shrink-0">
                                        <i class="fa-solid fa-star"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-xs font-bold uppercase tracking-wider text-slate-900">Penilaian Kepuasan Pelapor</h4>
                                        <p class="text-xs text-slate-500">Evaluasi kualitas penanganan fasilitas SMKN 2 Karanganyar</p>
                                    </div>
                                </div>

                                @if($ticketData->rating)
                                    <!-- Sudah Diulas -->
                                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 space-y-1.5">
                                        <div class="flex items-center gap-1 text-amber-500 text-sm">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fa-solid fa-star {{ $i <= $ticketData->rating ? 'text-amber-500' : 'text-slate-300' }}"></i>
                                            @endfor
                                            <span class="text-xs font-bold text-slate-800 ml-2">{{ $ticketData->rating }} / 5 Bintang</span>
                                        </div>
                                        <p class="text-xs text-slate-700 italic">
                                            “{{ $ticketData->ulasan_pelapor ?: 'Penanganan sangat baik dan tuntas.' }}”
                                        </p>
                                    </div>
                                @else
                                    <!-- Form Feedback -->
                                    <form action="{{ route('pengaduan.feedback', $ticketData) }}" method="POST" class="space-y-3 pt-1">
                                        @csrf
                                        <input type="hidden" name="rating" :value="rating">
                                        
                                        <div class="flex items-center gap-2">
                                            <span class="text-xs font-semibold text-slate-700 mr-2">Beri Nilai:</span>
                                            <template x-for="star in [1,2,3,4,5]" :key="star">
                                                <button type="button" @click="rating = star" class="text-xl transition" :class="rating >= star ? 'text-amber-500' : 'text-slate-300'">
                                                    ★
                                                </button>
                                            </template>
                                        </div>

                                        <textarea 
                                            name="ulasan_pelapor" 
                                            rows="2" 
                                            placeholder="Tulis ulasan Anda terkait hasil perbaikan petugas..." 
                                            class="w-full p-3 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-600 bg-white"
                                        ></textarea>

                                        <button type="submit" class="px-4 py-2 rounded-xl bg-blue-700 hover:bg-blue-800 text-white font-bold text-xs shadow-xs transition">
                                            Kirim Penilaian Kepuasan
                                        </button>
                                    </form>
                                @endif
                            </div>
                        @endif

                    </div>

                </div>

            </div>
        @else
            <!-- Initial Search State -->
            <div class="max-w-md mx-auto text-center py-16 space-y-2.5 text-slate-500">
                <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-400 mx-auto flex items-center justify-center text-xl">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>
                <h3 class="text-sm font-bold text-slate-800">Cek Status Pengaduan Anda</h3>
                <p class="text-xs">Gunakan kolom pencarian di atas untuk memasukkan nomor tiket resmi.</p>
            </div>
        @endif

    </main>

</x-app-layout>
