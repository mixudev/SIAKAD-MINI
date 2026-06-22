@php
    $user = auth()->user();
    $roleLabel = match(true) {
        $user->isAdmin() => 'Administrator',
        $user->isDosen() => 'Dosen',
        $user->isMahasiswa() => 'Mahasiswa',
        default => 'Pengguna',
    };
    $roleBadge = match(true) {
        $user->isAdmin() => 'Super Admin',
        $user->isDosen() => 'Dosen',
        $user->isMahasiswa() => 'Mahasiswa',
        default => '—',
    };
@endphp
            <header
                class="sticky top-0 z-10 bg-white border-b border-slate-200 px-4 lg:px-8 h-16 flex items-center justify-between gap-4">

                <!-- Left -->
                <div class="flex items-center gap-4">
                    <button onclick="toggleSidebar()"
                        class="lg:hidden text-slate-500 hover:text-slate-600 transition-colors duration-200">
                        <i class="fa-solid fa-bars text-xl"></i>
                    </button>
                    <div>
                        <h2 class="text-slate-900 font-bold text-sm lg:text-base leading-tight">Dashboard Akademik</h2>
                        <nav class="hidden sm:flex items-center gap-1 text-xs text-slate-400">
                            <span>Beranda</span>
                            <i class="fa-solid fa-chevron-right text-slate-300" style="font-size:0.6rem"></i>
                            <span class="text-slate-600 font-medium">Dashboard</span>
                        </nav>
                    </div>
                </div>

                <!-- Right -->
                <div class="flex items-center gap-2 lg:gap-4">
                    <!-- Notifikasi -->
                    <button
                        class="relative w-9 h-9 flex items-center justify-center text-slate-500 hover:text-slate-600 hover:bg-slate-50 transition-all duration-200 border border-transparent hover:border-slate-100">
                        <i class="fa-regular fa-bell text-base"></i>
                    </button>

                    <!-- User -->
                    <div class="flex items-center gap-2.5 pl-2 lg:pl-4 border-l border-slate-200">
                        <div class="w-8 h-8 bg-slate-600 flex items-center justify-center">
                            <i class="fa-solid fa-user text-white text-xs"></i>
                        </div>
                        <div class="hidden md:block">
                            <p class="text-slate-800 font-semibold text-xs">{{ $user->name }}</p>
                            <p class="text-slate-400 text-xs">{{ $roleBadge }}</p>
                        </div>
                    </div>
                </div>
            </header>
