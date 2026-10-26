<!-- Native-style Bottom Navigation for Smartphones -->
<nav class="md:hidden fixed bottom-0 left-0 right-0 z-40 bg-white/95 backdrop-blur-md border-t border-slate-200 shadow-sm px-3 py-1 flex items-center justify-around text-[10px] font-semibold text-slate-500 pb-safe">
    <a href="{{ route('home') }}" 
       class="flex flex-col items-center justify-center py-1.5 px-3 rounded-lg transition {{ request()->routeIs('home') ? 'text-blue-700 font-bold' : 'text-slate-500 hover:text-slate-900' }}">
        <i class="fa-solid fa-house text-sm mb-0.5"></i>
        <span>Beranda</span>
    </a>

    <a href="{{ route('pengaduan.create') }}" 
       class="flex flex-col items-center justify-center py-1.5 px-2 rounded-lg transition {{ request()->routeIs('pengaduan.create') ? 'text-blue-700 font-bold' : 'text-slate-500 hover:text-slate-900' }}">
        <i class="fa-solid fa-pen-to-square text-sm mb-0.5"></i>
        <span>Lapor</span>
    </a>

    <a href="{{ route('pengaduan.history') }}" 
       class="flex flex-col items-center justify-center py-1.5 px-2 rounded-lg transition {{ request()->routeIs('pengaduan.history') ? 'text-blue-700 font-bold' : 'text-slate-500 hover:text-slate-900' }}">
        <i class="fa-solid fa-clock-rotate-left text-sm mb-0.5"></i>
        <span>Riwayat</span>
    </a>

    <a href="{{ route('pengaduan.track') }}" 
       class="flex flex-col items-center justify-center py-1.5 px-2 rounded-lg transition {{ request()->routeIs('pengaduan.track') ? 'text-blue-700 font-bold' : 'text-slate-500 hover:text-slate-900' }}">
        <i class="fa-solid fa-magnifying-glass text-sm mb-0.5"></i>
        <span>Lacak</span>
    </a>

    @auth
        <a href="{{ route('admin.dashboard') }}" 
           class="flex flex-col items-center justify-center py-1.5 px-3 rounded-lg transition {{ request()->routeIs('admin.*') ? 'text-blue-700 font-bold' : 'text-slate-500 hover:text-slate-900' }}">
            <i class="fa-solid fa-shield-halved text-sm mb-0.5"></i>
            <span>Admin</span>
        </a>
    @else
        <a href="{{ route('login') }}" 
           class="flex flex-col items-center justify-center py-1.5 px-3 rounded-lg transition {{ request()->routeIs('login') ? 'text-blue-700 font-bold' : 'text-slate-500 hover:text-slate-900' }}">
            <i class="fa-solid fa-lock text-sm mb-0.5"></i>
            <span>Admin</span>
        </a>
    @endauth
</nav>
