<x-app-layout>
    <x-slot:title>Panel Petugas Lapangan — SIADU SMKN 2 Karanganyar</x-slot:title>

    <div x-data="petugasDashboardApp()">

        <!-- Sub Header & Breadcrumb -->
        <div class="bg-white border-b border-slate-200 py-3.5 shadow-xs">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div>
                    <h1 class="text-base sm:text-lg font-bold text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-wrench text-emerald-700"></i>
                        <span>Lembar Kerja Teknisi & Unit Pelaksana</span>
                    </h1>
                    <p class="text-xs text-slate-500">
                        {{ auth()->user()->name }} • {{ auth()->user()->unit ?? 'Unit Pelaksana Teknis SMKN 2 Karanganyar' }}
                    </p>
                </div>

                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.dashboard') }}" class="px-3 py-1.5 rounded-lg border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-semibold transition flex items-center gap-1.5">
                        <i class="fa-solid fa-shield-halved text-blue-700 text-xs"></i> Panel Admin
                    </a>
                    <a href="{{ route('pengaduan.track') }}" class="px-3 py-1.5 rounded-lg bg-blue-50 text-blue-800 hover:bg-blue-100 text-xs font-bold transition flex items-center gap-1.5 border border-blue-200">
                        <i class="fa-solid fa-magnifying-glass text-xs"></i> Cek Halaman Lacak
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full flex-1 space-y-6">

            <!-- Tab Filters (Baru, Proses, Selesai) -->
            <div class="flex flex-wrap items-center gap-1.5 border-b border-slate-200 pb-3">
                <a href="{{ route('petugas.dashboard', ['tab' => 'semua']) }}" 
                   class="px-3.5 py-1.5 rounded-lg text-xs font-bold transition flex items-center gap-1.5 {{ $tab === 'semua' ? 'bg-[#0a192f] text-white' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
                    <span>Semua Penugasan</span>
                    <span class="px-1.5 py-0.2 rounded text-[10px] {{ $tab === 'semua' ? 'bg-slate-700 text-white' : 'bg-slate-100 text-slate-600' }}">{{ $stats['total'] }}</span>
                </a>

                <a href="{{ route('petugas.dashboard', ['tab' => 'baru']) }}" 
                   class="px-3.5 py-1.5 rounded-lg text-xs font-bold transition flex items-center gap-1.5 {{ $tab === 'baru' ? 'bg-blue-700 text-white' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
                    <i class="fa-solid fa-bell text-[10px]"></i>
                    <span>Tugas Baru Masuk</span>
                    <span class="px-1.5 py-0.2 rounded text-[10px] {{ $tab === 'baru' ? 'bg-blue-900 text-white' : 'bg-blue-50 text-blue-800' }}">{{ $stats['baru'] }}</span>
                </a>

                <a href="{{ route('petugas.dashboard', ['tab' => 'proses']) }}" 
                   class="px-3.5 py-1.5 rounded-lg text-xs font-bold transition flex items-center gap-1.5 {{ $tab === 'proses' ? 'bg-amber-600 text-white' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
                    <i class="fa-solid fa-screwdriver-wrench text-[10px]"></i>
                    <span>Sedang Ditangani</span>
                    <span class="px-1.5 py-0.2 rounded text-[10px] {{ $tab === 'proses' ? 'bg-amber-800 text-white' : 'bg-amber-50 text-amber-800' }}">{{ $stats['proses'] }}</span>
                </a>

                <a href="{{ route('petugas.dashboard', ['tab' => 'selesai']) }}" 
                   class="px-3.5 py-1.5 rounded-lg text-xs font-bold transition flex items-center gap-1.5 {{ $tab === 'selesai' ? 'bg-emerald-700 text-white' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
                    <i class="fa-solid fa-circle-check text-[10px]"></i>
                    <span>Review & Selesai</span>
                    <span class="px-1.5 py-0.2 rounded text-[10px] {{ $tab === 'selesai' ? 'bg-emerald-900 text-white' : 'bg-emerald-50 text-emerald-800' }}">{{ $stats['selesai'] }}</span>
                </a>
            </div>

            <!-- List of Task Cards -->
            <div class="space-y-4">
                @forelse($tasks as $task)
                    <div class="bg-white rounded-xl p-5 border border-slate-200 shadow-xs hover:border-slate-300 transition space-y-4">
                        
                        <!-- Top Bar Card: Ticket Number, Category, Urgency, Target Deadline -->
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2.5 pb-3.5 border-b border-slate-100">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="font-mono text-xs sm:text-sm font-extrabold text-blue-900">#{{ $task->ticket_number }}</span>
                                <x-status-badge :status="$task->status" />
                                <span class="text-xs text-slate-400 font-medium">• Lapor: {{ $task->tanggal_lapor->translatedFormat('d M H:i') }}</span>
                            </div>

                            <div class="flex flex-wrap items-center gap-2">
                                <x-urgency-badge :urgensi="$task->effective_urgensi" />

                                @if($task->deadline)
                                    <span class="text-xs font-bold text-slate-700 bg-slate-100 px-2.5 py-1 rounded-lg">
                                        <i class="fa-regular fa-clock text-slate-400 mr-1"></i> Target: {{ $task->deadline->translatedFormat('d M H:i') }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Card Body: Judul, Uraian, Lokasi, Instruksi Admin, Foto -->
                        <div class="grid grid-cols-1 lg:grid-cols-12 gap-5">
                            
                            <div class="lg:col-span-8 space-y-2.5">
                                <h3 class="text-sm sm:text-base font-extrabold text-slate-900">{{ $task->judul }}</h3>
                                
                                <div class="flex items-center gap-2 text-xs font-semibold text-slate-700">
                                    <i class="fa-solid fa-location-dot text-rose-600"></i>
                                    <span>Lokasi: <span class="text-slate-900 font-bold">{{ $task->lokasi ?? 'Area Sekolah' }}</span></span>
                                </div>

                                <p class="text-xs text-slate-600 bg-slate-50 p-3 rounded-lg border border-slate-200/80 leading-relaxed font-normal">
                                    {{ $task->uraian }}
                                </p>

                                <!-- Instruksi Khusus Admin -->
                                @if($task->catatan_admin)
                                    <div class="p-3 rounded-lg bg-amber-50/70 border border-amber-200 text-xs">
                                        <span class="font-bold text-amber-900 block mb-0.5">
                                            <i class="fa-solid fa-note-sticky mr-1 text-amber-700"></i> Arahan Verifikator Admin:
                                        </span>
                                        <p class="text-amber-800 leading-relaxed">{{ $task->catatan_admin }}</p>
                                    </div>
                                @endif

                                <!-- Catatan Pengerjaan Petugas (Jika Ada) -->
                                @if($task->catatan_petugas)
                                    <div class="p-3 rounded-lg bg-slate-50 border border-slate-200 text-xs">
                                        <span class="font-bold text-slate-800 block mb-0.5">
                                            <i class="fa-solid fa-check-circle mr-1 text-emerald-600"></i> Catatan Pengerjaan Terakhir:
                                        </span>
                                        <p class="text-slate-700">{{ $task->catatan_petugas }}</p>
                                        @if($task->suku_cadang)
                                            <p class="text-[11px] text-slate-600 mt-1 font-semibold">Material / Suku Cadang: {{ $task->suku_cadang }}</p>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            <!-- Bukti Foto Awal & Action Buttons -->
                            <div class="lg:col-span-4 flex flex-col justify-between space-y-3">
                                <div>
                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Bukti Foto Pelapor:</span>
                                    @if($task->bukti_pelapor_url)
                                        <img src="{{ $task->bukti_pelapor_url }}" alt="Bukti Pelapor" class="w-full h-24 object-cover rounded-lg border border-slate-200">
                                    @else
                                        <div class="w-full h-20 rounded-lg border border-slate-200 bg-slate-50 flex items-center justify-center text-xs text-slate-400 italic">
                                            Tidak ada foto awal
                                        </div>
                                    @endif
                                </div>

                                <!-- Action Buttons Sesuai Status Alur -->
                                <div class="pt-2 border-t border-slate-100 flex flex-wrap gap-2 justify-end">
                                    
                                    @if($task->status === 'terverifikasi')
                                        <!-- Mulai Penanganan -->
                                        <form action="{{ route('petugas.start', $task) }}" method="POST" class="w-full">
                                            @csrf
                                            <button type="submit" class="w-full py-2 px-3 rounded-lg font-bold text-xs text-white bg-blue-700 hover:bg-blue-800 shadow-xs transition flex items-center justify-center gap-1.5 active:scale-98">
                                                <i class="fa-solid fa-play text-[9px]"></i> Mulai Penanganan Lapangan
                                            </button>
                                        </form>
                                    @elseif($task->status === 'dalam_proses')
                                        <!-- Catat Hasil & Bukti -->
                                        <button type="button" @click="openActionModal(@js($task))" class="w-full py-2 px-3 rounded-lg font-bold text-xs text-white bg-emerald-700 hover:bg-emerald-800 shadow-xs transition flex items-center justify-center gap-1.5 active:scale-98">
                                            <i class="fa-solid fa-camera text-[10px]"></i> Catat Hasil & Bukti Selesai
                                        </button>
                                    @else
                                        <a href="{{ route('pengaduan.track', ['ticket' => $task->ticket_number]) }}" class="w-full py-1.5 px-3 rounded-lg font-semibold text-xs text-slate-700 bg-slate-50 hover:bg-slate-100 border border-slate-200 transition text-center flex items-center justify-center gap-1">
                                            <span>Lihat di Halaman Lacak</span> <i class="fa-solid fa-arrow-up-right-from-square text-[9px] text-slate-400"></i>
                                        </a>
                                    @endif

                                </div>
                            </div>

                        </div>

                    </div>
                @empty
                    <div class="bg-white rounded-xl p-10 text-center border border-slate-200 shadow-xs space-y-2">
                        <div class="w-10 h-10 rounded-full bg-slate-100 text-slate-400 mx-auto flex items-center justify-center text-lg">
                            <i class="fa-solid fa-check"></i>
                        </div>
                        <h4 class="text-sm font-bold text-slate-800">Tidak Ada Tugas Pada Tab Ini</h4>
                        <p class="text-xs text-slate-500">Seluruh tugas pada kategori ini telah selesai atau belum ada penugasan baru dari verifikator admin.</p>
                    </div>
                @endforelse
            </div>

        </main>

        <!-- MODAL: CATAT HASIL PENANGANAN & UPLOAD BUKTI OLEH PETUGAS -->
        <div x-show="showActionModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
            <div class="bg-white rounded-2xl max-w-xl w-full p-6 sm:p-7 shadow-xl border border-slate-200 transform transition-all text-left">
                
                <div class="flex items-center justify-between border-b border-slate-200 pb-3 mb-4">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-800 flex items-center justify-center font-bold text-sm">
                            <i class="fa-solid fa-camera"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-slate-900">Catat Hasil Pengerjaan & Dokumentasi</h3>
                            <p class="text-[11px] text-slate-500">Laporkan tindakan perbaikan teknis yang telah selesai dikerjakan</p>
                        </div>
                    </div>
                    <button type="button" @click="showActionModal = false" class="p-1.5 text-slate-400 hover:text-slate-600 rounded-lg">
                        <i class="fa-solid fa-xmark text-base"></i>
                    </button>
                </div>

                <template x-if="selectedTask">
                    <form :action="'/petugas/pengaduan/' + selectedTask.id + '/resolve'" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf

                        <input type="hidden" name="bukti_petugas" x-model="actionForm.buktiPetugasUrl">

                        <!-- Task Summary -->
                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-200 text-xs space-y-1">
                            <div class="flex items-center justify-between">
                                <span class="font-mono font-bold text-blue-800" x-text="'#' + selectedTask.ticket_number"></span>
                                <span class="text-slate-500" x-text="selectedTask.lokasi || '-'"></span>
                            </div>
                            <span class="font-bold text-slate-900 block" x-text="selectedTask.judul"></span>
                        </div>

                        <!-- Catatan Petugas -->
                        <div>
                            <label class="block text-[11px] font-bold uppercase text-slate-700 mb-1">Catatan Tindakan Teknis / Solusi <span class="text-rose-500">*</span></label>
                            <textarea 
                                name="catatan_petugas" 
                                rows="3" 
                                x-model="actionForm.catatanPetugas" 
                                placeholder="Jelaskan tindakan yang telah diambil, komponen yang diganti, serta uji kelayakan." 
                                class="w-full p-2.5 rounded-xl border border-slate-300 text-xs font-normal focus:ring-2 focus:ring-emerald-600 bg-white"
                                required></textarea>
                        </div>

                        <!-- Suku Cadang -->
                        <div>
                            <label class="block text-[11px] font-bold uppercase text-slate-700 mb-1">Penggantian Komponen / Suku Cadang (Jika Ada)</label>
                            <input 
                                type="text" 
                                name="suku_cadang" 
                                x-model="actionForm.sukuCadang" 
                                placeholder="Contoh: 1x Unit Power Supply 450W Standar ATX" 
                                class="w-full p-2.5 rounded-xl border border-slate-300 text-xs font-medium focus:ring-2 focus:ring-emerald-600 bg-white">
                        </div>

                        <!-- Bukti Foto Pengerjaan -->
                        <div>
                                <label class="block text-[11px] font-bold uppercase text-slate-700 mb-1">Foto Bukti Hasil Pengerjaan (Kondisi Sesudah)</label>

                            <div class="border border-slate-300 rounded-xl p-3.5 text-center bg-slate-50 transition relative">
                                <input type="file" name="bukti_petugas_file" x-ref="petugasFileInput" @change="handleFileUpload($event)" class="hidden" accept="image/*">
                                
                                <template x-if="!actionForm.buktiPreview">
                                    <div class="space-y-1 py-1">
                                        <i class="fa-solid fa-camera text-slate-400 text-lg"></i>
                                        <p class="text-xs text-slate-700 font-semibold">
                                            <button type="button" @click="$refs.petugasFileInput.click()" class="text-blue-700 hover:underline">Pilih foto hasil perbaikan</button>
                                        </p>
                                        <p class="text-[10px] text-slate-400">JPG, PNG, WEBP (Maks 5MB)</p>
                                    </div>
                                </template>

                                <template x-if="actionForm.buktiPreview">
                                    <div class="flex items-center justify-between gap-3 text-left">
                                        <div class="flex items-center gap-3">
                                            <img :src="actionForm.buktiPreview" alt="Bukti Petugas" class="w-14 h-14 object-cover rounded-lg border border-slate-200">
                                            <div>
                                                <span class="text-xs font-bold text-slate-800 block">Foto Penyelesaian Terlampir</span>
                                                <span class="text-[11px] text-emerald-700 font-medium"><i class="fa-solid fa-check"></i> Siap diajukan ke admin</span>
                                            </div>
                                        </div>
                                        <button type="button" @click="clearActionImage()" class="text-xs text-rose-700 hover:text-rose-900 font-bold px-2.5 py-1 rounded-lg border border-rose-200 bg-white">
                                            Hapus
                                        </button>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <div class="pt-3 border-t border-slate-200 flex items-center justify-end gap-2.5">
                            <button type="button" @click="showActionModal = false" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-100">
                                Batal
                            </button>
                            <button type="submit" class="px-5 py-2.5 rounded-xl text-xs font-bold text-white bg-emerald-700 hover:bg-emerald-800 shadow-xs transition flex items-center gap-1.5">
                                <i class="fa-solid fa-paper-plane text-xs"></i> Ajukan Hasil Penanganan
                            </button>
                        </div>

                    </form>
                </template>

            </div>
        </div>

    </div>

    @push('scripts')
    <script>
        function petugasDashboardApp() {
            return {
                showActionModal: false,
                selectedTask: null,

                actionForm: {
                    catatanPetugas: '',
                    sukuCadang: '',
                    buktiPreview: null,
                    buktiPetugasUrl: ''
                },

                openActionModal(task) {
                    this.selectedTask = task;
                    this.actionForm.catatanPetugas = task.catatan_petugas || 'Perangkat telah dibersihkan, komponen daya diganti dengan stok inventaris baru, dan telah lulus uji kelayakan 30 menit.';
                    this.actionForm.sukuCadang = task.suku_cadang || '1x Unit Power Supply 450W Standar ATX';
                    this.actionForm.buktiPreview = task.bukti_petugas || null;
                    this.actionForm.buktiPetugasUrl = task.bukti_petugas || '';
                    this.showActionModal = true;
                },



                handleFileUpload(event) {
                    const file = event.target.files[0];
                    if (!file) return;
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.actionForm.buktiPreview = e.target.result;
                        this.actionForm.buktiPetugasUrl = e.target.result;
                    };
                    reader.readAsDataURL(file);
                },

                clearActionImage() {
                    this.actionForm.buktiPreview = null;
                    this.actionForm.buktiPetugasUrl = '';
                    if (this.$refs.petugasFileInput) {
                        this.$refs.petugasFileInput.value = '';
                    }
                }
            }
        }
    </script>
    @endpush

</x-app-layout>
