<x-app-layout>
    <x-slot:title>Masuk Administrator — SIADU SMKN 2 Karanganyar</x-slot:title>

    <main class="flex-1 flex items-center justify-center p-4 py-12">
        <div class="max-w-md w-full bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            
            <!-- School Emblem Header -->
            <div class="bg-[#0a192f] text-white p-6 sm:p-7 text-center border-b border-slate-800">
                <img 
                    src="https://smkn2kra.sch.id/images/logo-smkn2kra.png" 
                    alt="Logo SMKN 2 Kra" 
                    class="h-14 w-auto mx-auto mb-3"
                    onerror="this.onerror=null; this.src='https://placehold.co/120x120/1e293b/ffffff?text=SMKN+2+KRA';"
                >
                <div class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-blue-500/20 text-blue-300 border border-blue-400/30 text-[10px] font-bold mb-1.5 uppercase tracking-wider">
                    Khusus Administrator
                </div>
                <h1 class="text-lg sm:text-xl font-bold tracking-tight">Portal Masuk SIADU</h1>
                <p class="text-xs text-slate-300 mt-0.5">SMK Negeri 2 Karanganyar</p>
            </div>

            <!-- Login Form Body -->
            <div class="p-6 space-y-5">
                
                <!-- Notice Pelapor Bebas Login -->
                <div class="p-3.5 rounded-xl bg-blue-50 border border-blue-200 text-xs text-blue-900 space-y-1.5">
                    <div class="font-bold flex items-center gap-1.5 text-blue-800">
                        <i class="fa-solid fa-circle-info text-blue-600"></i>
                        <span>Pelapor Tidak Perlu Login</span>
                    </div>
                    <p class="text-slate-600 leading-relaxed text-[11px]">
                        Halaman ini khusus bagi Administrator sistem. Warga sekolah (siswa, guru, tenaga kependidikan, dan wali murid) dapat langsung menyampaikan laporan dan memantau riwayat pengaduan secara publik.
                    </p>
                    <div class="pt-0.5 flex items-center gap-2.5 text-xs font-bold text-blue-700">
                        <a href="{{ route('pengaduan.create') }}" class="hover:underline flex items-center gap-1">
                            <span>Form Pengaduan</span> <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </a>
                        <span class="text-slate-300">•</span>
                        <a href="{{ route('pengaduan.history') }}" class="hover:underline flex items-center gap-1">
                            <span>Riwayat Publik</span> <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </a>
                    </div>
                </div>

                <!-- Form Login Administrator -->
                <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">
                            Email / NIP Administrator <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="email" 
                            value="{{ old('email') }}" 
                            placeholder="admin.pengaduan@smkn2kra.sch.id" 
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm font-semibold text-slate-900 placeholder:text-slate-400 placeholder:font-normal focus:outline-none focus:ring-2 focus:ring-blue-600 bg-white"
                            required 
                            autofocus
                        >
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">
                            Kata Sandi <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="password" 
                            name="password" 
                            placeholder="Masukkan kata sandi administrator..." 
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm font-semibold text-slate-900 placeholder:text-slate-400 placeholder:font-normal focus:outline-none focus:ring-2 focus:ring-blue-600 bg-white"
                            required
                        >
                    </div>

                    <div class="flex items-center justify-between text-xs pt-0.5">
                        <label class="flex items-center gap-2 cursor-pointer text-slate-600">
                            <input type="checkbox" name="remember" value="1" class="rounded text-blue-700 focus:ring-blue-600">
                            <span>Ingat sesi masuk</span>
                        </label>
                    </div>

                    <button 
                        type="submit" 
                        class="w-full py-2.5 rounded-xl font-bold text-xs sm:text-sm text-white bg-blue-700 hover:bg-blue-800 shadow-sm transition flex items-center justify-center gap-2 active:scale-98">
                        <i class="fa-solid fa-lock text-xs"></i>
                        <span>Masuk ke Panel Administrator</span>
                    </button>
                </form>

            </div>

        </div>
    </main>

</x-app-layout>
