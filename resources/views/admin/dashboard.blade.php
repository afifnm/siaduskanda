<x-app-layout>
    <x-slot:title>Panel Admin — SIADU SMKN 2 Karanganyar</x-slot:title>

    <div x-data="adminDashboardApp()">
        
        <!-- Sub Header Toolbar / Breadcrumb -->
        <div class="bg-white border-b border-slate-200 py-3.5 shadow-xs">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div>
                    <h1 class="text-base sm:text-lg font-bold text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-shield-halved text-blue-700"></i>
                        <span>Panel Verifikator & Administrasi SIADU</span>
                    </h1>
                    <p class="text-xs text-slate-500">SMK Negeri 2 Karanganyar • Pengelolaan, Validasi, & Penugasan Unit Kerja</p>
                </div>

                <div class="flex items-center gap-2">
                    <a href="{{ route('pengaduan.create') }}" class="px-3.5 py-1.5 rounded-lg bg-blue-700 hover:bg-blue-800 text-white text-xs font-bold transition flex items-center gap-1.5 shadow-xs">
                        <i class="fa-solid fa-plus text-xs"></i> Formulir Baru
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full flex-1 space-y-6">

            <!-- KPI Metric Cards (5 Cards) -->
            <div class="grid grid-cols-2 lg:grid-cols-5 gap-3.5">
                <!-- 1 -->
                <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-xs">
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Total Laporan</span>
                    <div class="text-2xl font-black text-slate-900">{{ $stats['total'] }}</div>
                    <span class="text-[11px] text-slate-500 mt-1 block">Seluruh data tercatat</span>
                </div>

                <!-- 2 -->
                <div class="bg-white p-4 rounded-xl border border-amber-200 border-l-4 border-l-amber-500 shadow-xs">
                    <span class="text-[11px] font-bold text-amber-700 uppercase tracking-wider block mb-1">Perlu Verifikasi</span>
                    <div class="text-2xl font-black text-amber-700">{{ $stats['masuk'] }}</div>
                    <span class="text-[11px] text-slate-500 mt-1 block">Menunggu validasi admin</span>
                </div>

                <!-- 3 -->
                <div class="bg-white p-4 rounded-xl border border-blue-200 border-l-4 border-l-blue-600 shadow-xs">
                    <span class="text-[11px] font-bold text-blue-700 uppercase tracking-wider block mb-1">Dalam Penanganan</span>
                    <div class="text-2xl font-black text-blue-700">{{ $stats['proses'] + $stats['terverifikasi'] }}</div>
                    <span class="text-[11px] text-slate-500 mt-1 block">Proses fisik teknisi</span>
                </div>

                <!-- 4 -->
                <div class="bg-white p-4 rounded-xl border border-teal-200 border-l-4 border-l-teal-600 shadow-xs">
                    <span class="text-[11px] font-bold text-teal-700 uppercase tracking-wider block mb-1">Menunggu Review</span>
                    <div class="text-2xl font-black text-teal-700">{{ $stats['konfirmasi'] }}</div>
                    <span class="text-[11px] text-slate-500 mt-1 block">Hasil siap disahkan</span>
                </div>

                <!-- 5 -->
                <div class="bg-white p-4 rounded-xl border border-emerald-200 border-l-4 border-l-emerald-600 shadow-xs col-span-2 sm:col-span-1">
                    <span class="text-[11px] font-bold text-emerald-700 uppercase tracking-wider block mb-1">Selesai Tuntas</span>
                    <div class="text-2xl font-black text-emerald-700">{{ $stats['selesai'] }}</div>
                    <span class="text-[11px] text-slate-500 mt-1 block">Tiket ditutup resmi</span>
                </div>
            </div>

            <!-- Filter & Search Control Bar -->
            <form action="{{ route('admin.dashboard') }}" method="GET" class="bg-white p-3.5 rounded-xl border border-slate-200 shadow-xs flex flex-col md:flex-row items-stretch md:items-center justify-between gap-3">
                <div class="relative flex-1">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                        <i class="fa-solid fa-search text-xs"></i>
                    </span>
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ $search }}" 
                        placeholder="Cari kode tiket, judul aduan, nama pelapor, atau lokasi gedung..." 
                        class="w-full pl-8 pr-4 py-2 rounded-lg border border-slate-200 text-xs font-medium focus:ring-2 focus:ring-blue-600 bg-slate-50/50 focus:bg-white"
                    >
                </div>

                <div class="flex flex-wrap items-center gap-2">
                    <select name="status" onchange="this.form.submit()" class="px-2.5 py-2 rounded-lg border border-slate-200 text-xs font-medium text-slate-700 bg-white focus:outline-none">
                        <option value="all" {{ $status === 'all' ? 'selected' : '' }}>Semua Status</option>
                        <option value="masuk" {{ $status === 'masuk' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                        <option value="terverifikasi" {{ $status === 'terverifikasi' ? 'selected' : '' }}>Terverifikasi (Ditugaskan)</option>
                        <option value="dalam_proses" {{ $status === 'dalam_proses' ? 'selected' : '' }}>Sedang Ditangani</option>
                        <option value="menunggu_konfirmasi" {{ $status === 'menunggu_konfirmasi' ? 'selected' : '' }}>Menunggu Review Selesai</option>
                        <option value="selesai" {{ $status === 'selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>

                    <select name="kategori" onchange="this.form.submit()" class="px-2.5 py-2 rounded-lg border border-slate-200 text-xs font-medium text-slate-700 bg-white focus:outline-none">
                        <option value="all" {{ $kategori === 'all' ? 'selected' : '' }}>Semua Kategori</option>
                        <option value="Sarana dan prasarana" {{ $kategori === 'Sarana dan prasarana' ? 'selected' : '' }}>Sarana dan prasarana</option>
                        <option value="Pembelajaran dan akademik" {{ $kategori === 'Pembelajaran dan akademik' ? 'selected' : '' }}>Pembelajaran & akademik</option>
                        <option value="Layanan administrasi" {{ $kategori === 'Layanan administrasi' ? 'selected' : '' }}>Layanan administrasi</option>
                        <option value="Perlindungan warga sekolah" {{ $kategori === 'Perlindungan warga sekolah' ? 'selected' : '' }}>Perlindungan warga sekolah</option>
                        <option value="Saran dan aspirasi" {{ $kategori === 'Saran dan aspirasi' ? 'selected' : '' }}>Saran dan aspirasi</option>
                    </select>

                    <button type="submit" class="px-3.5 py-2 rounded-lg bg-blue-700 text-white font-bold text-xs hover:bg-blue-800 transition">
                        Filter
                    </button>
                    @if($status !== 'all' || $kategori !== 'all' || $search !== '')
                        <a href="{{ route('admin.dashboard') }}" class="px-2.5 py-2 rounded-lg border border-slate-200 text-slate-600 text-xs font-medium hover:bg-slate-50 transition">
                            Reset
                        </a>
                    @endif
                </div>
            </form>

            <!-- Table of Complaints -->
            <div class="bg-white rounded-xl border border-slate-200 shadow-xs overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200 text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                                <th class="p-3.5 pl-5">Tiket & Tanggal</th>
                                <th class="p-3.5">Pokok Masalah</th>
                                <th class="p-3.5">Pelapor</th>
                                <th class="p-3.5">Kategori & Urgensi</th>
                                <th class="p-3.5">Status & Unit</th>
                                <th class="p-3.5 pr-5 text-right">Aksi Tindak Lanjut</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-xs">
                            @forelse($reports as $report)
                                <tr class="hover:bg-slate-50/70 transition">
                                    <td class="p-3.5 pl-5 align-top">
                                        <a href="{{ route('pengaduan.track', ['ticket' => $report->ticket_number]) }}" class="font-mono font-bold text-blue-800 block hover:underline">
                                            #{{ $report->ticket_number }}
                                        </a>
                                        <span class="text-[11px] text-slate-400 block mt-0.5">
                                            {{ $report->tanggal_lapor->translatedFormat('d M Y, H:i') }}
                                        </span>
                                    </td>

                                    <td class="p-3.5 align-top max-w-xs">
                                        <div class="font-bold text-slate-900 text-xs sm:text-sm mb-0.5">{{ $report->judul }}</div>
                                        <p class="text-slate-500 line-clamp-2 text-[11px] leading-relaxed">{{ $report->uraian }}</p>
                                        @if($report->lokasi)
                                            <div class="text-[11px] text-slate-600 font-medium mt-1 flex items-center gap-1">
                                                <i class="fa-solid fa-location-dot text-slate-400 text-[10px]"></i>
                                                <span class="truncate">{{ $report->lokasi }}</span>
                                            </div>
                                        @endif
                                    </td>

                                    <td class="p-3.5 align-top whitespace-nowrap">
                                        <div class="font-semibold text-slate-800">
                                            {{ $report->is_anonim ? 'Pelapor Anonim' : $report->nama_pelapor }}
                                        </div>
                                        <span class="text-[11px] text-slate-400 block">{{ $report->jenis_pelapor }}</span>
                                        @if(!$report->is_anonim && $report->kontak)
                                            <span class="text-[10px] text-slate-500 block mt-0.5">{{ $report->kontak }}</span>
                                        @endif
                                    </td>

                                    <td class="p-3.5 align-top whitespace-nowrap space-y-1">
                                        <span class="block text-slate-700 font-medium">{{ $report->kategori }}</span>
                                        <x-urgency-badge :urgensi="$report->effective_urgensi" />
                                    </td>

                                    <td class="p-3.5 align-top whitespace-nowrap space-y-1">
                                        <x-status-badge :status="$report->status" />
                                        @if($report->nama_petugas)
                                            <div class="text-[11px] text-slate-600 font-medium flex items-center gap-1 mt-1">
                                                <i class="fa-solid fa-user-gear text-slate-400"></i>
                                                <span class="truncate max-w-[140px]">{{ $report->nama_petugas }}</span>
                                            </div>
                                        @endif
                                        @if($report->unit_tujuan)
                                            <span class="text-[10px] text-slate-400 block">{{ $report->unit_tujuan }}</span>
                                        @endif
                                    </td>

                                    <td class="p-3.5 pr-5 align-top text-right whitespace-nowrap">
                                        @if($report->status === 'masuk')
                                            <!-- Verifikasi & Tugaskan -->
                                            <button 
                                                type="button"
                                                @click="openAssignModal(@js($report))" 
                                                class="px-3 py-1.5 rounded-lg bg-blue-700 hover:bg-blue-800 text-white font-bold text-xs shadow-xs transition flex items-center gap-1.5 ml-auto">
                                                <i class="fa-solid fa-user-plus text-[10px]"></i> Verifikasi & Delegasi
                                            </button>
                                        @elseif($report->status === 'menunggu_konfirmasi')
                                            <!-- Tinjau & Tutup -->
                                            <button 
                                                type="button"
                                                @click="openReviewModal(@js($report))" 
                                                class="px-3 py-1.5 rounded-lg bg-teal-700 hover:bg-teal-800 text-white font-bold text-xs shadow-xs transition flex items-center gap-1.5 ml-auto">
                                                <i class="fa-solid fa-clipboard-check text-xs"></i> Tinjau & Tutup
                                            </button>
                                        @else
                                            <a href="{{ route('pengaduan.track', ['ticket' => $report->ticket_number]) }}" 
                                               class="px-2.5 py-1 rounded-lg border border-slate-200 hover:bg-slate-50 text-slate-700 font-medium text-xs transition inline-flex items-center gap-1">
                                                <span>Detail</span> <i class="fa-solid fa-arrow-up-right-from-square text-[9px] text-slate-400"></i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-10 text-center text-slate-500">
                                        <div class="w-10 h-10 rounded-full bg-slate-100 text-slate-400 mx-auto flex items-center justify-center text-lg mb-2">
                                            <i class="fa-solid fa-inbox"></i>
                                        </div>
                                        Tidak ada laporan pengaduan yang sesuai filter pencarian.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </main>

        <!-- MODAL 1: VERIFIKASI & PENUGASAN UNIT OLEH ADMIN -->
        <div x-show="showAssignModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
            <div class="bg-white rounded-2xl max-w-2xl w-full p-6 sm:p-7 shadow-xl border border-slate-200 transform transition-all text-left">
                
                <div class="flex items-center justify-between border-b border-slate-200 pb-3 mb-4">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-800 flex items-center justify-center font-bold text-sm">
                            <i class="fa-solid fa-shield-halved"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-slate-900">Verifikasi & Delegasi Penugasan Unit</h3>
                            <p class="text-[11px] text-slate-500">Tetapkan urgensi sekolah, unit kerja tujuan, dan tenggat waktu (SLA)</p>
                        </div>
                    </div>
                    <button type="button" @click="showAssignModal = false" class="p-1.5 text-slate-400 hover:text-slate-600 rounded-lg">
                        <i class="fa-solid fa-xmark text-base"></i>
                    </button>
                </div>

                <template x-if="selectedTicket">
                    <form :action="'/admin/pengaduan/' + selectedTicket.id + '/assign'" method="POST" class="space-y-4">
                        @csrf

                        <!-- Ringkasan Tiket -->
                        <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200 text-xs space-y-1.5">
                            <div class="flex items-center justify-between">
                                <span class="font-mono font-bold text-blue-800" x-text="'#' + selectedTicket.ticket_number"></span>
                                <span class="text-slate-500 font-medium" x-text="selectedTicket.kategori"></span>
                            </div>
                            <span class="font-bold text-slate-900 block" x-text="selectedTicket.judul"></span>
                            <p class="text-slate-600 italic leading-relaxed" x-text="'“' + selectedTicket.uraian + '”'"></p>
                            <div class="pt-2 border-t border-slate-200 flex flex-wrap gap-3 text-[11px] text-slate-500">
                                <span>Pelapor: <strong class="text-slate-800" x-text="selectedTicket.is_anonim ? 'Anonim' : selectedTicket.nama_pelapor"></strong></span>
                                <span>Lokasi: <strong class="text-slate-800" x-text="selectedTicket.lokasi || '-'"></strong></span>
                                <span>Urgensi Pelapor: <strong class="text-amber-700" x-text="selectedTicket.urgensi_pelapor"></strong></span>
                            </div>
                        </div>

                        <!-- Form Input Penugasan -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                            <div>
                                <label class="block text-[11px] font-bold uppercase text-slate-700 mb-1">Kategori Definitif</label>
                                <select name="kategori_definitif" x-model="assignForm.kategoriDefinitif" class="w-full p-2.5 rounded-xl border border-slate-300 text-xs font-medium focus:ring-2 focus:ring-blue-600 bg-white">
                                    <option value="Sarana dan prasarana">Sarana dan prasarana</option>
                                    <option value="Pembelajaran dan akademik">Pembelajaran dan akademik</option>
                                    <option value="Layanan administrasi">Layanan administrasi</option>
                                    <option value="Perlindungan warga sekolah">Perlindungan warga sekolah</option>
                                    <option value="Saran dan aspirasi">Saran dan aspirasi</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-[11px] font-bold uppercase text-slate-700 mb-1">Urgensi Resmi Sekolah <span class="text-rose-500">*</span></label>
                                <select name="urgensi_admin" x-model="assignForm.urgensiAdmin" class="w-full p-2.5 rounded-xl border border-slate-300 text-xs font-medium focus:ring-2 focus:ring-blue-600 bg-white" required>
                                    <option value="Normal">Normal (SLA 3 Hari Kerja)</option>
                                    <option value="Mendesak">Mendesak (SLA 24 Jam)</option>
                                    <option value="Ada risiko keselamatan">Risiko Keselamatan (SLA Segera < 4 Jam)</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                            <div>
                                <label class="block text-[11px] font-bold uppercase text-slate-700 mb-1">Tugaskan ke Unit <span class="text-rose-500">*</span></label>
                                <select name="unit_tujuan" x-model="assignForm.unitTujuan" class="w-full p-2.5 rounded-xl border border-slate-300 text-xs font-medium focus:ring-2 focus:ring-blue-600 bg-white" required>
                                    <option value="Unit Sarana dan Prasarana (Listrik & Gedung)">Unit Sarpras (Listrik & Gedung)</option>
                                    <option value="Unit IT & Lab Komputer">Unit IT & Lab Komputer</option>
                                    <option value="Unit Kesiswaan & Bimbingan Konseling (BK)">Unit Kesiswaan & Tim BK</option>
                                    <option value="Unit Tata Usaha (TU) Administrasi">Unit Tata Usaha (TU)</option>
                                    <option value="Unit Kurikulum & Pembelajaran">Unit Kurikulum</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-[11px] font-bold uppercase text-slate-700 mb-1">Nama Petugas / Teknisi PIC</label>
                                <input type="text" name="nama_petugas" x-model="assignForm.namaPetugas" placeholder="Contoh: Pak Joko (Teknisi Listrik)" class="w-full p-2.5 rounded-xl border border-slate-300 text-xs font-medium focus:ring-2 focus:ring-blue-600 bg-white">
                            </div>
                        </div>

                        <!-- Target Deadline -->
                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <label class="block text-[11px] font-bold uppercase text-slate-700">Tenggat Waktu Target (SLA)</label>
                                <div class="flex items-center gap-1 text-[11px]">
                                    <button type="button" @click="setDeadlineHours(24)" class="px-2 py-0.5 rounded bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium">+24 Jam</button>
                                    <button type="button" @click="setDeadlineHours(48)" class="px-2 py-0.5 rounded bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium">+48 Jam</button>
                                    <button type="button" @click="setDeadlineHours(72)" class="px-2 py-0.5 rounded bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium">+72 Jam</button>
                                </div>
                            </div>
                            <input type="text" name="deadline" x-model="assignForm.deadline" placeholder="YYYY-MM-DD HH:mm" class="w-full p-2.5 rounded-xl border border-slate-300 text-xs font-medium focus:ring-2 focus:ring-blue-600 bg-white">
                        </div>

                        <!-- Catatan Instruksi Admin -->
                        <div>
                            <label class="block text-[11px] font-bold uppercase text-slate-700 mb-1">Instruksi Khusus untuk Teknisi</label>
                            <textarea name="catatan_admin" rows="2" x-model="assignForm.catatanAdmin" placeholder="Contoh: Segera lakukan pemeriksaan fisik sebelum jam praktikum dimulai." class="w-full p-2.5 rounded-xl border border-slate-300 text-xs font-normal focus:ring-2 focus:ring-blue-600 bg-white"></textarea>
                        </div>

                        <div class="pt-3 border-t border-slate-200 flex items-center justify-end gap-2.5">
                            <button type="button" @click="showAssignModal = false" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-100">
                                Batal
                            </button>
                            <button type="submit" class="px-5 py-2.5 rounded-xl text-xs font-bold text-white bg-blue-700 hover:bg-blue-800 shadow-xs transition flex items-center gap-1.5">
                                <i class="fa-solid fa-check text-xs"></i> Simpan & Delegasikan Tugas
                            </button>
                        </div>

                    </form>
                </template>

            </div>
        </div>

        <!-- MODAL 2: TINJAU & PENUTUPAN RESMI TIKET OLEH ADMIN -->
        <div x-show="showReviewModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
            <div class="bg-white rounded-2xl max-w-xl w-full p-6 sm:p-7 shadow-xl border border-slate-200 transform transition-all text-left">
                
                <div class="flex items-center justify-between border-b border-slate-200 pb-3 mb-4">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-teal-100 text-teal-800 flex items-center justify-center font-bold text-sm">
                            <i class="fa-solid fa-clipboard-check"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-slate-900">Tinjau Hasil & Sahkan Penutupan Tiket</h3>
                            <p class="text-[11px] text-slate-500">Evaluasi dokumentasi pengerjaan teknisi sebelum tiket berstatus Selesai Tuntas</p>
                        </div>
                    </div>
                    <button type="button" @click="showReviewModal = false" class="p-1.5 text-slate-400 hover:text-slate-600 rounded-lg">
                        <i class="fa-solid fa-xmark text-base"></i>
                    </button>
                </div>

                <template x-if="selectedTicket">
                    <form :action="'/admin/pengaduan/' + selectedTicket.id + '/close'" method="POST" class="space-y-4">
                        @csrf

                        <!-- Ringkasan Pekerjaan Petugas -->
                        <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200 text-xs space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="font-mono font-bold text-blue-800" x-text="'#' + selectedTicket.ticket_number"></span>
                                <span class="text-emerald-700 font-bold">Laporan Pengerjaan Tersedia</span>
                            </div>
                            <span class="font-bold text-slate-900 block" x-text="selectedTicket.judul"></span>
                            
                            <div class="p-2.5 rounded-lg bg-white border border-slate-200 space-y-1">
                                <span class="text-[10px] text-slate-400 uppercase font-bold block">Catatan Solusi Petugas:</span>
                                <p class="text-slate-800 leading-relaxed" x-text="selectedTicket.catatan_petugas || 'Pekerjaan perbaikan telah selesai dilaksanakan.'"></p>
                            </div>

                            <template x-if="selectedTicket.suku_cadang">
                                <div class="text-[11px] text-slate-600 font-medium">
                                    <strong>Suku cadang / Material:</strong> <span x-text="selectedTicket.suku_cadang"></span>
                                </div>
                            </template>
                        </div>

                        <!-- Feedback Verifikasi Penutupan -->
                        <div>
                            <label class="block text-[11px] font-bold uppercase text-slate-700 mb-1">Catatan Pengesahan Penutupan Resmi</label>
                            <textarea 
                                name="admin_close_feedback" 
                                rows="3" 
                                x-model="adminCloseFeedback" 
                                placeholder="Pekerjaan telah diverifikasi dan berfungsi baik sesuai standar SOP SMKN 2 Karanganyar." 
                                class="w-full p-2.5 rounded-xl border border-slate-300 text-xs font-normal focus:ring-2 focus:ring-teal-600 bg-white"
                                required></textarea>
                        </div>

                        <div class="pt-3 border-t border-slate-200 flex items-center justify-end gap-2.5">
                            <button type="button" @click="showReviewModal = false" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-100">
                                Batal
                            </button>
                            <button type="submit" class="px-5 py-2.5 rounded-xl text-xs font-bold text-white bg-emerald-700 hover:bg-emerald-800 shadow-xs transition flex items-center gap-1.5">
                                <i class="fa-solid fa-check"></i> Setujui & Sahkan Tiket Selesai
                            </button>
                        </div>

                    </form>
                </template>

            </div>
        </div>

    </div>

    @push('scripts')
    <script>
        function adminDashboardApp() {
            return {
                showAssignModal: false,
                showReviewModal: false,
                selectedTicket: null,
                adminCloseFeedback: 'Hasil pekerjaan telah diperiksa langsung dan dinyatakan tuntas sesuai standar SOP SMKN 2 Karanganyar.',

                assignForm: {
                    kategoriDefinitif: 'Sarana dan prasarana',
                    urgensiAdmin: 'Normal',
                    unitTujuan: 'Unit IT & Lab Komputer',
                    namaPetugas: '',
                    deadline: '',
                    catatanAdmin: 'Segera lakukan pengecekan dan laporkan sebelum jadwal praktikum siswa.'
                },

                openAssignModal(ticket) {
                    this.selectedTicket = ticket;
                    this.assignForm.kategoriDefinitif = ticket.kategori_definitif || ticket.kategori;
                    this.assignForm.urgensiAdmin = ticket.urgensi_admin || ticket.urgensi_pelapor || 'Normal';
                    this.assignForm.unitTujuan = ticket.unit_tujuan || 'Unit IT & Lab Komputer';
                    this.assignForm.namaPetugas = ticket.nama_petugas || '';
                    this.setDeadlineHours(48);
                    this.assignForm.catatanAdmin = 'Segera lakukan pengecekan dan laporkan sebelum jadwal praktikum siswa.';
                    this.showAssignModal = true;
                },

                openReviewModal(ticket) {
                    this.selectedTicket = ticket;
                    this.adminCloseFeedback = 'Hasil pekerjaan telah diperiksa langsung dan dinyatakan tuntas sesuai standar SOP SMKN 2 Karanganyar.';
                    this.showReviewModal = true;
                },

                setDeadlineHours(hours) {
                    const d = new Date();
                    d.setHours(d.getHours() + hours);
                    const pad = (n) => String(n).padStart(2, '0');
                    this.assignForm.deadline = `${d.getFullYear()}-${pad(d.getMonth() + 1)}-${pad(d.getDate())} ${pad(d.getHours())}:00`;
                }
            }
        }
    </script>
    @endpush

</x-app-layout>
