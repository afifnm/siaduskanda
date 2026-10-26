<header class="sticky top-0 z-50 bg-white/95 backdrop-blur-md shadow-xs border-b border-slate-200" x-data="{ mobileMenu: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            
            <!-- School Brand Identity -->
            <a href="{{ route('home') }}" class="flex items-center gap-3.5 group">
                <img 
                    src="https://smkn2kra.sch.id/images/logo-smkn2kra.png" 
                    alt="Logo SMKN 2 Karanganyar" 
                    class="h-11 sm:h-12 w-auto object-contain transition-transform group-hover:scale-102"
                    onerror="this.onerror=null; this.src='https://placehold.co/120x120/1e293b/ffffff?text=SMKN+2+KRA';"
                >
                <div class="flex flex-col">
                    <span class="text-[10px] sm:text-[11px] font-bold tracking-wider text-slate-500 uppercase">SMK NEGERI 2 KARANGANYAR</span>
                    <span class="text-base sm:text-lg font-extrabold text-[#0a192f] tracking-tight flex items-center gap-2">
                        SIADU
                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-blue-600 text-white border border-blue-500 uppercase tracking-wide flex items-center gap-1 shadow-xs">
                            <i class="fa-solid fa-bullhorn text-[9px]"></i> Layanan Pengaduan
                        </span>
                    </span>
                </div>
            </a>

            <!-- Desktop Navigation Links -->
            <nav class="hidden md:flex items-center gap-1 text-xs sm:text-sm font-semibold text-slate-600">
                <a href="{{ route('home') }}" 
                   class="px-3 py-2 rounded-lg transition flex items-center gap-1.5 {{ request()->routeIs('home') ? 'text-blue-700 bg-blue-50/70 font-bold' : 'hover:text-blue-700 hover:bg-slate-50' }}">
                    <i class="fa-solid fa-house text-xs opacity-70"></i>
                    <span>Beranda</span>
                </a>
                <a href="{{ route('pengaduan.create') }}" 
                   class="px-3 py-2 rounded-lg transition flex items-center gap-1.5 {{ request()->routeIs('pengaduan.create') ? 'text-blue-700 bg-blue-50/70 font-bold' : 'hover:text-blue-700 hover:bg-slate-50' }}">
                    <i class="fa-solid fa-pen-to-square text-xs text-blue-600"></i>
                    <span>Buat Pengaduan</span>
                </a>
                <a href="{{ route('pengaduan.history') }}" 
                   class="px-3 py-2 rounded-lg transition flex items-center gap-1.5 {{ request()->routeIs('pengaduan.history') ? 'text-blue-700 bg-blue-50/70 font-bold' : 'hover:text-blue-700 hover:bg-slate-50' }}">
                    <i class="fa-solid fa-clock-rotate-left text-xs opacity-70"></i>
                    <span>Riwayat Publik</span>
                </a>
                <a href="{{ route('pengaduan.track') }}" 
                   class="px-3 py-2 rounded-lg transition flex items-center gap-1.5 {{ request()->routeIs('pengaduan.track') ? 'text-blue-700 bg-blue-50/70 font-bold' : 'hover:text-blue-700 hover:bg-slate-50' }}">
                    <i class="fa-solid fa-magnifying-glass text-xs opacity-70"></i>
                    <span>Lacak Tiket</span>
                </a>

                <div class="h-4 w-[1px] bg-slate-200 mx-2"></div>

                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" 
                           class="px-3 py-2 rounded-lg transition flex items-center gap-1.5 {{ request()->routeIs('admin.*') ? 'text-blue-800 bg-blue-100/70 font-bold' : 'text-slate-700 hover:text-blue-700 hover:bg-slate-50' }}">
                            <i class="fa-solid fa-shield-halved text-blue-600 text-xs"></i> Panel Admin
                        </a>
                    @endif
                @else
                    <a href="{{ route('login') }}" 
                       class="px-3 py-2 rounded-lg text-slate-700 hover:text-blue-700 hover:bg-slate-50 transition flex items-center gap-1.5">
                        <i class="fa-solid fa-lock text-slate-400 text-xs"></i> Masuk Admin
                    </a>
                @endauth
            </nav>

            <!-- CTA Button Desktop -->
            <div class="hidden lg:flex items-center gap-3">
                <a href="{{ route('pengaduan.create') }}" 
                   class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl font-bold text-xs text-white bg-blue-700 hover:bg-blue-800 shadow-sm transition active:scale-98">
                    <i class="fa-solid fa-bullhorn text-xs"></i>
                    <span>Lapor Sekarang</span>
                </a>
            </div>

            <!-- Mobile Menu Toggle Button -->
            <button @click="mobileMenu = !mobileMenu" 
                    type="button" 
                    class="md:hidden p-2.5 rounded-lg text-slate-600 hover:bg-slate-100 focus:outline-none"
                    aria-label="Buka Menu Navigasi">
                <i class="fa-solid text-xl" :class="mobileMenu ? 'fa-xmark' : 'fa-bars'"></i>
            </button>
        </div>
    </div>

    <!-- Mobile Drawer Menu -->
    <div x-show="mobileMenu" 
         x-transition:enter="transition ease-out duration-150"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-100"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="md:hidden border-t border-slate-200 bg-white px-4 pt-3 pb-5 space-y-1 shadow-lg">
        <a href="{{ route('home') }}" 
           class="block px-3 py-2 rounded-lg text-xs font-semibold {{ request()->routeIs('home') ? 'text-blue-700 bg-blue-50 font-bold' : 'text-slate-700 hover:bg-slate-50' }}">
            <i class="fa-solid fa-house w-5 text-slate-400 mr-1.5"></i> Beranda Utama
        </a>
        <a href="{{ route('pengaduan.create') }}" 
           class="block px-3 py-2 rounded-lg text-xs font-semibold {{ request()->routeIs('pengaduan.create') ? 'text-blue-700 bg-blue-50 font-bold' : 'text-slate-700 hover:bg-slate-50' }}">
            <i class="fa-solid fa-pen-to-square w-5 text-slate-400 mr-1.5"></i> Buat Pengaduan
        </a>
        <a href="{{ route('pengaduan.history') }}" 
           class="block px-3 py-2 rounded-lg text-xs font-semibold {{ request()->routeIs('pengaduan.history') ? 'text-blue-700 bg-blue-50 font-bold' : 'text-slate-700 hover:bg-slate-50' }}">
            <i class="fa-solid fa-clock-rotate-left w-5 text-slate-400 mr-1.5"></i> Riwayat Publik
        </a>
        <a href="{{ route('pengaduan.track') }}" 
           class="block px-3 py-2 rounded-lg text-xs font-semibold {{ request()->routeIs('pengaduan.track') ? 'text-blue-700 bg-blue-50 font-bold' : 'text-slate-700 hover:bg-slate-50' }}">
            <i class="fa-solid fa-magnifying-glass w-5 text-slate-400 mr-1.5"></i> Lacak Progres Tiket
        </a>
        
        <div class="pt-2 border-t border-slate-100 space-y-1">
            <span class="px-3 text-[10px] font-bold uppercase tracking-wider text-slate-400 block pt-1">Internal Sekolah</span>
            @auth
                <a href="{{ route('admin.dashboard') }}" 
                   class="block px-3 py-2 rounded-lg text-xs font-medium text-slate-700 hover:bg-slate-50">
                    <i class="fa-solid fa-shield-halved text-blue-600 mr-2 w-4"></i> Panel Administrator
                </a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full text-left px-3 py-2 rounded-lg text-xs font-medium text-rose-600 hover:bg-rose-50 flex items-center">
                        <i class="fa-solid fa-arrow-right-from-bracket mr-2 w-4"></i> Keluar Akun ({{ auth()->user()->name }})
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" 
                   class="block px-3 py-2 rounded-lg text-xs font-medium text-slate-700 hover:bg-slate-50">
                    <i class="fa-solid fa-right-to-bracket text-amber-500 mr-2 w-4"></i> Masuk Admin
                </a>
            @endauth
        </div>

        <div class="pt-3">
            <a href="{{ route('pengaduan.create') }}" 
               class="w-full inline-flex justify-center items-center gap-2 px-4 py-2.5 rounded-xl font-bold text-xs text-white bg-blue-700 shadow-sm">
                <i class="fa-solid fa-paper-plane text-[10px]"></i> Tulis Pengaduan Sekarang
            </a>
        </div>
    </div>
</header>
