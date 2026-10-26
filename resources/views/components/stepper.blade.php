@props(['status', 'stepIndex' => 1])

<div class="pt-5 pb-1">
    <h4 class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-4">
        Tahapan Progres Penanganan:
    </h4>
    
    <div class="relative">
        <!-- Connecting Line (Desktop) -->
        <div class="absolute top-4 left-6 right-6 h-0.5 bg-slate-200 -z-0 hidden md:block"></div>
        
        <div class="grid grid-cols-1 md:grid-cols-5 gap-3.5 relative z-10">
            <!-- Step 1: Laporan Masuk -->
            <div class="flex md:flex-col items-center md:text-center gap-3 bg-slate-50/60 md:bg-transparent p-2.5 md:p-0 rounded-xl">
                <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs bg-blue-700 text-white shadow-xs shrink-0">
                    <i class="fa-solid fa-check"></i>
                </div>
                <div>
                    <div class="text-xs font-bold text-slate-900">1. Laporan Masuk</div>
                    <div class="text-[11px] text-slate-500">Tercatat di sistem</div>
                </div>
            </div>

            <!-- Step 2: Verifikasi Admin -->
            <div class="flex md:flex-col items-center md:text-center gap-3 bg-slate-50/60 md:bg-transparent p-2.5 md:p-0 rounded-xl">
                <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs shrink-0 {{ $stepIndex >= 2 ? 'bg-blue-700 text-white shadow-xs' : 'bg-white border border-slate-300 text-slate-400' }}">
                    <i class="fa-solid {{ $stepIndex >= 2 ? 'fa-check' : 'fa-clipboard-check' }}"></i>
                </div>
                <div>
                    <div class="text-xs font-bold text-slate-900">2. Verifikasi Admin</div>
                    <div class="text-[11px] text-slate-500">Validasi & Urgensi</div>
                </div>
            </div>

            <!-- Step 3: Penugasan Unit -->
            <div class="flex md:flex-col items-center md:text-center gap-3 bg-slate-50/60 md:bg-transparent p-2.5 md:p-0 rounded-xl">
                <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs shrink-0 {{ $stepIndex >= 2 && $status !== 'masuk' ? 'bg-blue-700 text-white shadow-xs' : 'bg-white border border-slate-300 text-slate-400' }}">
                    <i class="fa-solid {{ $stepIndex >= 2 && $status !== 'masuk' ? 'fa-check' : 'fa-user-gear' }}"></i>
                </div>
                <div>
                    <div class="text-xs font-bold text-slate-900">3. Penugasan Unit</div>
                    <div class="text-[11px] text-slate-500">Instruksi & SLA</div>
                </div>
            </div>

            <!-- Step 4: Tindakan Lapangan -->
            <div class="flex md:flex-col items-center md:text-center gap-3 bg-slate-50/60 md:bg-transparent p-2.5 md:p-0 rounded-xl">
                <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs shrink-0 {{ $stepIndex >= 3 ? 'bg-blue-700 text-white shadow-xs' : 'bg-white border border-slate-300 text-slate-400' }}">
                    <i class="fa-solid {{ $stepIndex >= 4 ? 'fa-check' : 'fa-wrench' }}"></i>
                </div>
                <div>
                    <div class="text-xs font-bold text-slate-900">4. Penanganan</div>
                    <div class="text-[11px] text-slate-500">Tindakan fisik/teknis</div>
                </div>
            </div>

            <!-- Step 5: Selesai Tuntas -->
            <div class="flex md:flex-col items-center md:text-center gap-3 bg-slate-50/60 md:bg-transparent p-2.5 md:p-0 rounded-xl">
                <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs shrink-0 {{ $status === 'selesai' ? 'bg-emerald-700 text-white shadow-xs' : 'bg-white border border-slate-300 text-slate-400' }}">
                    <i class="fa-solid {{ $status === 'selesai' ? 'fa-check' : 'fa-flag-checkered' }}"></i>
                </div>
                <div>
                    <div class="text-xs font-bold text-slate-900">5. Selesai Tuntas</div>
                    <div class="text-[11px] text-slate-500">Pengesahan resmi</div>
                </div>
            </div>
        </div>
    </div>
</div>
