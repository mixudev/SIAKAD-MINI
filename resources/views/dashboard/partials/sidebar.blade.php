@php
    $user = auth()->user();
@endphp
<aside id="sidebar"
    class="fixed top-0 left-0 h-full w-64 bg-slate-950 z-30 flex flex-col -translate-x-full lg:translate-x-0 transition-transform duration-300">

    <div class="flex items-center gap-3 px-6 py-5 border-b border-slate-800">
        <div class="w-9 h-9 bg-slate-500 flex items-center justify-center">
            <i class="fa-solid fa-graduation-cap text-white text-lg"></i>
        </div>
        <div>
            <p class="text-white font-bold text-sm tracking-widest uppercase">SIAKAD</p>
            <p class="text-slate-400 text-xs tracking-wider">MINI</p>
        </div>
    </div>

    <nav class="flex-1 px-3 py-4 space-y-0.5 overflow-y-auto">
        <p class="text-slate-500 text-xs font-semibold tracking-widest uppercase px-3 pt-2 pb-1">Menu Utama</p>

        @if ($user->isAdmin())
            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-3 px-3 py-2.5 {{ request()->routeIs('admin.dashboard') ? 'text-white bg-slate-700 border-l-4 border-slate-300' : 'text-slate-300 border-l-4 border-transparent hover:bg-slate-900 hover:text-white hover:border-slate-500' }} group transition-all duration-200">
                <i class="fa-solid fa-gauge-high w-4"></i>
                <span class="text-sm font-semibold">Dashboard</span>
            </a>
            <a href="{{ route('admin.akun.index') }}"
                class="flex items-center gap-3 px-3 py-2.5 {{ request()->routeIs('admin.akun.*') ? 'text-white bg-slate-700 border-l-4 border-slate-300' : 'text-slate-300 border-l-4 border-transparent hover:bg-slate-900 hover:text-white hover:border-slate-500' }} group transition-all duration-200">
                <i class="fa-solid fa-user-gear w-4"></i>
                <span class="text-sm">Akun</span>
            </a>
            <a href="{{ route('admin.mahasiswa.index') }}"
                class="flex items-center gap-3 px-3 py-2.5 {{ request()->routeIs('admin.mahasiswa.*') ? 'text-white bg-slate-700 border-l-4 border-slate-300' : 'text-slate-300 border-l-4 border-transparent hover:bg-slate-900 hover:text-white hover:border-slate-500' }} group transition-all duration-200">
                <i class="fa-solid fa-user-graduate w-4"></i>
                <span class="text-sm">Mahasiswa</span>
            </a>
            <a href="{{ route('admin.dosen.index') }}"
                class="flex items-center gap-3 px-3 py-2.5 {{ request()->routeIs('admin.dosen.*') ? 'text-white bg-slate-700 border-l-4 border-slate-300' : 'text-slate-300 border-l-4 border-transparent hover:bg-slate-900 hover:text-white hover:border-slate-500' }} group transition-all duration-200">
                <i class="fa-solid fa-chalkboard-user w-4"></i>
                <span class="text-sm">Dosen</span>
            </a>
            <a href="{{ route('admin.mata-kuliah.index') }}"
                class="flex items-center gap-3 px-3 py-2.5 {{ request()->routeIs('admin.mata-kuliah.*') ? 'text-white bg-slate-700 border-l-4 border-slate-300' : 'text-slate-300 border-l-4 border-transparent hover:bg-slate-900 hover:text-white hover:border-slate-500' }} group transition-all duration-200">
                <i class="fa-solid fa-book-open w-4"></i>
                <span class="text-sm">Mata Kuliah</span>
            </a>
            <a href="{{ route('admin.semester.index') }}"
                class="flex items-center gap-3 px-3 py-2.5 {{ request()->routeIs('admin.semester.*') ? 'text-white bg-slate-700 border-l-4 border-slate-300' : 'text-slate-300 border-l-4 border-transparent hover:bg-slate-900 hover:text-white hover:border-slate-500' }} group transition-all duration-200">
                <i class="fa-solid fa-calendar-days w-4"></i>
                <span class="text-sm">Semester</span>
            </a>
            <a href="{{ route('admin.kelas-matkul.index') }}"
                class="flex items-center gap-3 px-3 py-2.5 {{ request()->routeIs('admin.kelas-matkul.*') ? 'text-white bg-slate-700 border-l-4 border-slate-300' : 'text-slate-300 border-l-4 border-transparent hover:bg-slate-900 hover:text-white hover:border-slate-500' }} group transition-all duration-200">
                <i class="fa-solid fa-layer-group w-4"></i>
                <span class="text-sm">Kelas Matkul</span>
            </a>

            <p class="text-slate-500 text-xs font-semibold tracking-widest uppercase px-3 pt-4 pb-1">Akademik</p>

            <a href="{{ route('admin.krs.index') }}"
                class="flex items-center gap-3 px-3 py-2.5 {{ request()->routeIs('admin.krs.*') ? 'text-white bg-slate-700 border-l-4 border-slate-300' : 'text-slate-300 border-l-4 border-transparent hover:bg-slate-900 hover:text-white hover:border-slate-500' }} group transition-all duration-200">
                <i class="fa-solid fa-clipboard-list w-4"></i>
                <span class="text-sm">KRS</span>
            </a>
            <a href="{{ route('admin.nilai.index') }}"
                class="flex items-center gap-3 px-3 py-2.5 {{ request()->routeIs('admin.nilai.*') ? 'text-white bg-slate-700 border-l-4 border-slate-300' : 'text-slate-300 border-l-4 border-transparent hover:bg-slate-900 hover:text-white hover:border-slate-500' }} group transition-all duration-200">
                <i class="fa-solid fa-star-half-stroke w-4"></i>
                <span class="text-sm">Nilai</span>
            </a>
            <a href="{{ route('admin.khs.index') }}"
                class="flex items-center gap-3 px-3 py-2.5 {{ request()->routeIs('admin.khs.*') ? 'text-white bg-slate-700 border-l-4 border-slate-300' : 'text-slate-300 border-l-4 border-transparent hover:bg-slate-900 hover:text-white hover:border-slate-500' }} group transition-all duration-200">
                <i class="fa-solid fa-file-lines w-4"></i>
                <span class="text-sm">KHS</span>
            </a>
        @endif

        @if ($user->isMahasiswa())
            <a href="{{ route('mahasiswa.dashboard') }}"
                class="flex items-center gap-3 px-3 py-2.5 {{ request()->routeIs('mahasiswa.dashboard') ? 'text-white bg-slate-700 border-l-4 border-slate-300' : 'text-slate-300 border-l-4 border-transparent hover:bg-slate-900 hover:text-white hover:border-slate-500' }} group transition-all duration-200">
                <i class="fa-solid fa-gauge-high w-4"></i>
                <span class="text-sm font-semibold">Dashboard</span>
            </a>
            <a href="{{ route('mahasiswa.krs.index') }}"
                class="flex items-center gap-3 px-3 py-2.5 {{ request()->routeIs('mahasiswa.krs.*') ? 'text-white bg-slate-700 border-l-4 border-slate-300' : 'text-slate-300 border-l-4 border-transparent hover:bg-slate-900 hover:text-white hover:border-slate-500' }} group transition-all duration-200">
                <i class="fa-solid fa-clipboard-list w-4"></i>
                <span class="text-sm">KRS</span>
            </a>
            <a href="{{ route('mahasiswa.khs.index') }}"
                class="flex items-center gap-3 px-3 py-2.5 {{ request()->routeIs('mahasiswa.khs.*') ? 'text-white bg-slate-700 border-l-4 border-slate-300' : 'text-slate-300 border-l-4 border-transparent hover:bg-slate-900 hover:text-white hover:border-slate-500' }} group transition-all duration-200">
                <i class="fa-solid fa-star-half-stroke w-4"></i>
                <span class="text-sm">KHS</span>
            </a>
        @endif

        @if ($user->isDosen())
            <a href="{{ route('dosen.dashboard') }}"
                class="flex items-center gap-3 px-3 py-2.5 {{ request()->routeIs('dosen.dashboard') ? 'text-white bg-slate-700 border-l-4 border-slate-300' : 'text-slate-300 border-l-4 border-transparent hover:bg-slate-900 hover:text-white hover:border-slate-500' }} group transition-all duration-200">
                <i class="fa-solid fa-gauge-high w-4"></i>
                <span class="text-sm font-semibold">Dashboard</span>
            </a>
            <a href="{{ route('dosen.nilai.index') }}"
                class="flex items-center gap-3 px-3 py-2.5 {{ request()->routeIs('dosen.nilai.*') ? 'text-white bg-slate-700 border-l-4 border-slate-300' : 'text-slate-300 border-l-4 border-transparent hover:bg-slate-900 hover:text-white hover:border-slate-500' }} group transition-all duration-200">
                <i class="fa-solid fa-star-half-stroke w-4"></i>
                <span class="text-sm">Nilai</span>
            </a>
        @endif
    </nav>

    <div class="px-4 py-4 border-t border-slate-800">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 bg-slate-600 flex items-center justify-center">
                <i class="fa-solid fa-user text-white text-xs"></i>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-white text-xs font-semibold truncate">{{ $user->name }}</p>
                <p class="text-slate-400 text-xs truncate">{{ $user->identifier }}</p>
            </div>
            <form method="POST" action="{{ route('logout') }}" id="logout-form">
                @csrf
                <button type="button" onclick="confirmLogout()"
                    class="text-slate-400 hover:text-white transition-colors duration-200">
                    <i class="fa-solid fa-right-from-bracket text-xs"></i>
                </button>
            </form>
        </div>
    </div>
</aside>

<script>
    function confirmLogout() {
        AppPopup.confirm({
            title: 'Akhiri sesi sekarang?',
            description: 'Aktivitas Anda telah tersimpan dengan aman.',
            confirmText: 'Ya, Keluar',
            cancelText: 'Batal',
            onConfirm: () => document.getElementById('logout-form').submit()
        });
    }
</script>
