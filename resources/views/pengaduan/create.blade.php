<x-app-layout>
    <x-slot:title>Formulir Pengaduan — SIADU SMKN 2 Karanganyar</x-slot:title>

    <!-- Breadcrumb & Step Progress Bar -->
    <div class="bg-white border-b border-slate-200 py-3.5">
        <div class="max-w-4xl mx-auto px-4 sm:px-6">
            <div class="flex items-center justify-between text-xs font-semibold text-slate-500">
                <div class="flex items-center gap-2 text-blue-700 font-bold">
                    <span class="w-6 h-6 rounded-full bg-blue-700 text-white flex items-center justify-center text-xs">1</span>
                    <span>Isi Formulir Aduan</span>
                </div>
                <div class="flex-1 h-0.5 bg-slate-200 mx-3"></div>
                <div class="flex items-center gap-2">
                    <span class="w-6 h-6 rounded-full bg-slate-100 text-slate-500 border border-slate-300 flex items-center justify-center text-xs font-bold">2</span>
                    <span>Penerbitan Nomor Tiket</span>
                </div>
                <div class="flex-1 h-0.5 bg-slate-200 mx-3"></div>
                <div class="flex items-center gap-2">
                    <span class="w-6 h-6 rounded-full bg-slate-100 text-slate-500 border border-slate-300 flex items-center justify-center text-xs font-bold">3</span>
                    <span>Pelacakan Progres</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Container -->
    <main class="max-w-3xl mx-auto px-4 sm:px-6 py-8 w-full flex-1" x-data="createComplaintForm()">

        <!-- Form Card Container -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            
            <!-- Official Header Title -->
            <div class="bg-[#0a192f] text-white p-6 sm:p-7 border-b border-slate-800">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-emerald-500/20 text-emerald-300 border border-emerald-400/30 text-[11px] font-bold mb-2">
                            <i class="fa-solid fa-lock-open text-[10px]"></i> Pelapor Tanpa Perlu Login
                        </div>
                        <h1 class="text-xl sm:text-2xl font-black text-white">Formulir Pengaduan Resmi</h1>
                        <p class="text-xs text-slate-300 mt-1">SMK Negeri 2 Karanganyar • Terbuka untuk seluruh siswa, guru, staf, & wali murid</p>
                    </div>
                    <img 
                        src="https://smkn2kra.sch.id/images/logo-smkn2kra.png" 
                        alt="Logo" 
                        class="h-12 w-auto opacity-90 hidden sm:block"
                        onerror="this.onerror=null; this.src='https://placehold.co/120x120/1e293b/ffffff?text=SMK';"
                    >
                </div>
            </div>

            <!-- Notice Pelapor Bebas Login -->
            <div class="p-4 bg-blue-50 border-b border-blue-100 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 text-xs text-blue-900">
                <div class="flex items-center gap-2.5">
                    <i class="fa-solid fa-circle-check text-blue-600 text-base shrink-0"></i>
                    <span>Pelapor <strong>tidak diwajibkan login</strong>. Cukup isi formulir di bawah ini dan simpan nomor tiket yang diterbitkan sistem.</span>
                </div>
                <a href="{{ route('pengaduan.history') }}" class="font-bold text-blue-700 hover:text-blue-900 whitespace-nowrap flex items-center gap-1">
                    <span>Lihat Riwayat Publik</span>
                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
            </div>

            <!-- Form Content -->
            <form action="{{ route('pengaduan.store') }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-7">
                @csrf

                <!-- 1. Kategori Pengaduan -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2.5">
                        1. Kategori Masalah / Layanan <span class="text-rose-500">*</span>
                    </label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                        @foreach([
                            ['val' => 'Sarana dan prasarana', 'label' => 'Sarana & Prasarana', 'desc' => 'Kelistrikan, mebeler, mesin bengkel, sanitasi', 'icon' => 'fa-wrench'],
                            ['val' => 'Pembelajaran dan akademik', 'label' => 'Fasilitas IT & Lab Komputer', 'desc' => 'PC Lab, proyektor, Wi-Fi, jaringan', 'icon' => 'fa-desktop'],
                            ['val' => 'Perlindungan warga sekolah', 'label' => 'Perlindungan Warga Sekolah', 'desc' => 'Anti-perundungan, bullying, keamanan', 'icon' => 'fa-shield-halved'],
                            ['val' => 'Layanan administrasi', 'label' => 'Administrasi & Kesiswaan', 'desc' => 'Layanan TU, perpustakaan, PKL, ijazah', 'icon' => 'fa-file-lines'],
                            ['val' => 'Saran dan aspirasi', 'label' => 'Saran & Aspirasi Mutu', 'desc' => 'Usulan pengembangan kegiatan & sekolah', 'icon' => 'fa-comment-dots'],
                        ] as $cat)
                            <label class="p-3.5 rounded-xl border transition cursor-pointer flex items-start gap-3"
                                   :class="kategori === '{{ $cat['val'] }}' ? 'border-blue-700 bg-blue-50/60 ring-1 ring-blue-700' : 'border-slate-200 hover:border-slate-300 bg-white'">
                                <input 
                                    type="radio" 
                                    name="kategori" 
                                    value="{{ $cat['val'] }}" 
                                    x-model="kategori" 
                                    class="w-4 h-4 text-blue-700 focus:ring-blue-600 border-slate-300 mt-0.5"
                                    required
                                >
                                <div>
                                    <div class="text-xs font-bold text-slate-900 flex items-center gap-1.5">
                                        <i class="fa-solid {{ $cat['icon'] }} text-slate-400 text-xs w-4"></i>
                                        <span>{{ $cat['label'] }}</span>
                                    </div>
                                    <p class="text-[11px] text-slate-500 mt-0.5">{{ $cat['desc'] }}</p>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- 2. Jenis Pelapor & Identitas Box -->
                <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/90 space-y-4">
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label class="text-xs font-bold uppercase tracking-wider text-slate-700">
                                2. Identitas Pelapor <span class="text-rose-500">*</span>
                            </label>
                            <label class="inline-flex items-center gap-2 cursor-pointer text-xs font-semibold text-slate-600 select-none">
                                <input type="checkbox" name="is_anonim" value="1" x-model="isAnonim" class="rounded text-blue-700 focus:ring-blue-600">
                                <span>Kirim Sebagai Anonim</span>
                            </label>
                        </div>

                        <!-- Role Selector -->
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 mb-3">
                            @foreach(['Siswa', 'Guru', 'Tenaga kependidikan', 'Orang tua/wali'] as $role)
                                <label class="p-2.5 rounded-lg border text-center transition cursor-pointer text-xs font-semibold"
                                       :class="jenisPelapor === '{{ $role }}' ? 'border-blue-700 bg-white text-blue-900 ring-1 ring-blue-700' : 'border-slate-200 bg-white text-slate-600 hover:border-slate-300'">
                                    <input 
                                        type="radio" 
                                        name="jenis_pelapor" 
                                        value="{{ $role }}" 
                                        x-model="jenisPelapor" 
                                        class="sr-only"
                                        required
                                    >
                                    <span>{{ $role }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Open Identity Inputs -->
                    <div x-show="!isAnonim" class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 pt-1">
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Nama Lengkap / Identitas</label>
                            <input 
                                type="text" 
                                name="nama_pelapor" 
                                x-model="namaPelapor" 
                                placeholder="Contoh: Rizky Pratama (XI RPL 1)" 
                                class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-medium focus:outline-none focus:ring-2 focus:ring-blue-600 bg-white"
                            >
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">No. WhatsApp / Kontak (Opsional)</label>
                            <input 
                                type="text" 
                                name="kontak" 
                                x-model="kontak" 
                                placeholder="Contoh: 081234567890" 
                                class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-medium focus:outline-none focus:ring-2 focus:ring-blue-600 bg-white"
                            >
                        </div>
                    </div>
                    
                    <div x-show="isAnonim" class="p-3 rounded-xl bg-amber-50 border border-amber-200 text-xs text-amber-900 leading-relaxed">
                        <i class="fa-solid fa-user-secret mr-1.5 text-amber-700"></i>
                        <strong>Perlindungan Privasi:</strong> Laporan ini akan diproses tanpa menyertakan nama dan kontak Anda di lembar kerja penanganan teknis.
                    </div>
                </div>

                <!-- 3. Judul Laporan -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        3. Pokok Masalah / Judul Pengaduan <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="judul" 
                        x-model="judul" 
                        placeholder="Ringkasan kendala, contoh: Komputer PC Lab RPL 2 Nomor 14 Tidak Mau Menyala" 
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm font-semibold text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-600 bg-white"
                        required
                    >
                </div>

                <!-- 4. Lokasi Kejadian -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        4. Lokasi Gedung / Ruang Spesifik
                    </label>
                    <input 
                        type="text" 
                        name="lokasi" 
                        x-model="lokasi" 
                        placeholder="Contoh: Laboratorium Komputer RPL 2, Gedung C Lantai 2" 
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm font-medium text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-600 bg-white"
                    >
                    <div class="flex flex-wrap items-center gap-1.5 mt-2">
                        <span class="text-[11px] text-slate-400">Pilihan cepat:</span>
                        <button type="button" @click="lokasi = 'Laboratorium Komputer RPL 2, Gedung C Lt. 2'" class="text-[11px] bg-slate-100 hover:bg-slate-200 px-2 py-0.5 rounded text-slate-700 font-medium">Lab RPL</button>
                        <button type="button" @click="lokasi = 'Bengkel Teknik Pemesinan Bubut 1'" class="text-[11px] bg-slate-100 hover:bg-slate-200 px-2 py-0.5 rounded text-slate-700 font-medium">Bengkel Mesin</button>
                        <button type="button" @click="lokasi = 'Bengkel Otomotif TKR Gedung B'" class="text-[11px] bg-slate-100 hover:bg-slate-200 px-2 py-0.5 rounded text-slate-700 font-medium">Bengkel TKR</button>
                        <button type="button" @click="lokasi = 'Ruang Teori 12 RPL Lantai 2'" class="text-[11px] bg-slate-100 hover:bg-slate-200 px-2 py-0.5 rounded text-slate-700 font-medium">Ruang Teori 12</button>
                        <button type="button" @click="lokasi = 'Perpustakaan Pusat SMKN 2 Kra'" class="text-[11px] bg-slate-100 hover:bg-slate-200 px-2 py-0.5 rounded text-slate-700 font-medium">Perpustakaan</button>
                        <button type="button" @click="lokasi = 'Toilet Siswa Gedung B Lantai 1'" class="text-[11px] bg-slate-100 hover:bg-slate-200 px-2 py-0.5 rounded text-slate-700 font-medium">Toilet Siswa</button>
                    </div>
                </div>

                <!-- 5. Uraian Pengaduan -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        5. Uraian Rinci Pengaduan <span class="text-rose-500">*</span>
                    </label>
                    <textarea 
                        name="uraian" 
                        rows="4" 
                        x-model="uraian" 
                        placeholder="Deskripsikan kendala yang dialami, kronologi kejadian, dan pengaruhnya terhadap aktivitas belajar mengajar di sekolah." 
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm font-normal text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-600 bg-white leading-relaxed"
                        required
                    ></textarea>
                </div>

                <!-- 6. Urgensi yang Dirasakan Pelapor -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                        6. Tingkat Urgensi Penanganan <span class="text-rose-500">*</span>
                    </label>
                    <div class="space-y-2">
                        <label class="p-3 rounded-xl border transition cursor-pointer flex items-center gap-3"
                               :class="urgensiPelapor === 'Normal' ? 'border-blue-700 bg-blue-50/60 ring-1 ring-blue-700' : 'border-slate-200 bg-white hover:border-slate-300'">
                            <input 
                                type="radio" 
                                name="urgensi_pelapor" 
                                value="Normal" 
                                x-model="urgensiPelapor" 
                                class="w-4 h-4 text-blue-700 focus:ring-blue-600 border-slate-300"
                                required
                            >
                            <div>
                                <span class="text-xs font-bold text-slate-800">Normal (Standar SLA 2-3 Hari Kerja)</span>
                                <p class="text-[11px] text-slate-500">Kerusakan umum yang tidak menghambat proses belajar darurat.</p>
                            </div>
                        </label>

                        <label class="p-3 rounded-xl border transition cursor-pointer flex items-center gap-3"
                               :class="urgensiPelapor === 'Mendesak' ? 'border-amber-600 bg-amber-50/60 ring-1 ring-amber-600' : 'border-slate-200 bg-white hover:border-slate-300'">
                            <input 
                                type="radio" 
                                name="urgensi_pelapor" 
                                value="Mendesak" 
                                x-model="urgensiPelapor" 
                                class="w-4 h-4 text-amber-600 focus:ring-amber-500 border-slate-300"
                            >
                            <div>
                                <span class="text-xs font-bold text-slate-800">Mendesak (SLA 24 Jam)</span>
                                <p class="text-[11px] text-slate-500">Mengganggu praktikum siswa, ujian sekolah, atau layanan harian.</p>
                            </div>
                        </label>

                        <label class="p-3 rounded-xl border transition cursor-pointer flex items-center gap-3"
                               :class="urgensiPelapor === 'Ada risiko keselamatan' ? 'border-rose-600 bg-rose-50/60 ring-1 ring-rose-600' : 'border-slate-200 bg-white hover:border-slate-300'">
                            <input 
                                type="radio" 
                                name="urgensi_pelapor" 
                                value="Ada risiko keselamatan" 
                                x-model="urgensiPelapor" 
                                class="w-4 h-4 text-rose-600 focus:ring-rose-500 border-slate-300"
                            >
                            <div>
                                <span class="text-xs font-bold text-rose-900">Ada Risiko Keselamatan (Penanganan Segera)</span>
                                <p class="text-[11px] text-rose-700">Percikan listrik, kabel terbuka, plafon lapuk, atau ancaman bahaya fisik.</p>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- 7. Lampiran Foto Bukti -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        7. Foto Bukti Kejadian / Kerusakan <span class="text-slate-400 font-normal lowercase">(opsional)</span>
                    </label>
                    
                    <input type="hidden" name="bukti_pelapor" x-model="buktiPelaporUrl">

                    <div class="border border-slate-300 rounded-xl p-4 bg-slate-50 text-center relative hover:border-slate-400 transition">
                        <input type="file" name="bukti_pelapor_file" x-ref="fileInput" @change="handleFileUpload($event)" class="hidden" accept="image/*">
                        
                        <template x-if="!buktiPreview">
                            <div class="space-y-2 py-2">
                                <div class="w-10 h-10 mx-auto rounded-full bg-slate-200 text-slate-600 flex items-center justify-center text-sm">
                                    <i class="fa-solid fa-camera"></i>
                                </div>
                                <div class="text-xs font-semibold text-slate-700">
                                    <button type="button" @click="$refs.fileInput.click()" class="text-blue-700 hover:underline font-bold">Pilih foto dari perangkat</button> atau ambil foto langsung
                                </div>
                                <div class="text-[11px] text-slate-400">Format JPG, PNG, WEBP (Otomatis dikonversi dan dikompresi WebP)</div>
                            </div>
                        </template>

                        <template x-if="buktiPreview">
                            <div class="flex items-center justify-between gap-4 text-left p-1">
                                <div class="flex items-center gap-3">
                                    <img :src="buktiPreview" alt="Bukti Foto" class="w-16 h-16 object-cover rounded-xl border border-slate-200">
                                    <div>
                                        <span class="text-xs font-bold text-slate-900 block">Foto Berhasil Dilampirkan</span>
                                        <span class="text-[11px] text-emerald-700 font-medium"><i class="fa-solid fa-check"></i> Siap dikirim bersama aduan</span>
                                    </div>
                                </div>
                                <button type="button" @click="clearImage()" class="text-xs text-rose-700 hover:text-rose-900 font-bold px-3 py-1.5 rounded-lg border border-rose-200 bg-white">
                                    Ganti Foto
                                </button>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- 8. Pernyataan & Checkbox -->
                <div class="pt-1">
                    <label class="flex items-start gap-2.5 cursor-pointer text-xs text-slate-600">
                        <input type="checkbox" required class="mt-0.5 rounded text-blue-700 focus:ring-blue-600">
                        <span class="leading-relaxed">Saya menyatakan bahwa informasi yang saya sampaikan adalah benar untuk kepentingan penanganan fasilitas dan mutu lingkungan belajar di SMK Negeri 2 Karanganyar.</span>
                    </label>
                </div>

                <!-- Action Buttons -->
                <div class="pt-4 border-t border-slate-200 flex flex-col sm:flex-row items-center gap-3 justify-end">
                    <a href="{{ route('home') }}" class="w-full sm:w-auto px-5 py-2.5 rounded-xl border border-slate-300 text-slate-700 font-semibold text-xs hover:bg-slate-50 text-center transition">
                        Batal
                    </a>
                    <button type="submit" 
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-7 py-3 rounded-xl font-bold text-xs text-white bg-blue-700 hover:bg-blue-800 shadow-sm transition active:scale-98">
                        <i class="fa-solid fa-paper-plane text-[11px]"></i>
                        Kirim Laporan Pengaduan
                    </button>
                </div>

            </form>
        </div>

        <div class="mt-6 text-center text-xs text-slate-500 space-y-1">
            <p>Pusat Bantuan & Konfirmasi Pengaduan SMKN 2 Karanganyar • Telepon: (0271) 494549</p>
        </div>
    </main>

    @push('scripts')
    <script>
        function createComplaintForm() {
            return {
                kategori: '{{ old('kategori', request('kategori', 'Sarana dan prasarana')) }}',
                jenisPelapor: '{{ old('jenis_pelapor', 'Siswa') }}',
                namaPelapor: '{{ old('nama_pelapor', auth()->user()?->name ?? '') }}',
                kontak: '{{ old('kontak', auth()->user()?->phone ?? '') }}',
                judul: '{{ old('judul', '') }}',
                lokasi: '{{ old('lokasi', '') }}',
                uraian: '{{ old('uraian', '') }}',
                urgensiPelapor: '{{ old('urgensi_pelapor', 'Normal') }}',
                isAnonim: false,
                buktiPreview: null,
                buktiPelaporUrl: '',

                handleFileUpload(event) {
                    const file = event.target.files[0];
                    if (!file) return;
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.buktiPreview = e.target.result;
                        this.buktiPelaporUrl = e.target.result;
                    };
                    reader.readAsDataURL(file);
                },



                clearImage() {
                    this.buktiPreview = null;
                    this.buktiPelaporUrl = '';
                    if (this.$refs.fileInput) {
                        this.$refs.fileInput.value = '';
                    }
                }
            }
        }
    </script>
    @endpush

</x-app-layout>
