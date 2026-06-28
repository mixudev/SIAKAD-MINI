@php
    $current = request()->route('view', '');
@endphp
<div class="flex items-center gap-3 px-5 py-5 border-b border-stone-200">
    <div class="w-8 h-8 bg-amber-100 flex items-center justify-center">
        <i class="fas fa-book-open text-amber-700 text-sm"></i>
    </div>
    <div>
        <a href="{{ route('docs.index') }}" class="text-sm font-bold text-stone-900 hover:text-amber-700 transition-colors">SIAKAD Mini</a>
        <p class="text-[11px] text-stone-400 leading-tight">Dokumentasi Sistem</p>
    </div>
</div>

<nav class="flex-1 overflow-y-auto px-3 py-5 space-y-6" id="docs-nav">
    <div>
        <p class="text-[10px] font-semibold text-stone-400 uppercase tracking-[0.15em] px-3 mb-1">Pendahuluan</p>
        <a href="{{ route('docs.show', 'tentang') }}"
           class="sidebar-link {{ str_starts_with($current, 'tentang') ? 'active' : '' }}">
            <i class="sidebar-icon fas fa-info-circle"></i>
            <span>Tentang Sistem</span>
        </a>
    </div>

    @php
        $sections = [
            'mahasiswa' => ['label' => 'Mahasiswa', 'icon' => 'fa-user-graduate', 'pages' => [
                '' => 'Ikhtisar',
                'dashboard' => 'Dashboard',
                'krs' => 'KRS',
                'khs' => 'KHS',
            ]],
            'dosen' => ['label' => 'Dosen', 'icon' => 'fa-chalkboard-teacher', 'pages' => [
                '' => 'Ikhtisar',
                'dashboard' => 'Dashboard',
                'nilai' => 'Nilai',
            ]],
            'admin' => ['label' => 'Admin', 'icon' => 'fa-user-shield', 'pages' => [
                '' => 'Ikhtisar',
                'dashboard' => 'Dashboard',
                'akun' => 'Akun',
                'mahasiswa' => 'Mahasiswa',
                'dosen' => 'Dosen',
                'mata-kuliah' => 'Mata Kuliah',
                'semester' => 'Semester',
                'kelas-matkul' => 'Kelas Matkul',
                'krs' => 'KRS',
                'nilai' => 'Nilai',
                'khs' => 'KHS',
            ]],
        ];
    @endphp

    @foreach ($sections as $key => $section)
        <div>
            <p class="text-[10px] font-semibold text-stone-400 uppercase tracking-[0.15em] px-3 mb-1 flex items-center gap-2">
                <i class="fas {{ $section['icon'] }} text-[11px] text-stone-300"></i>
                {{ $section['label'] }}
            </p>
            <div class="space-y-0.5">
                @foreach ($section['pages'] as $page => $label)
                    @php
                        $routeParams = $page === '' ? $key : "$key/$page";
                        $isPageActive = $current === $routeParams;
                    @endphp
                    <a href="{{ route('docs.show', $routeParams) }}"
                       class="sidebar-link {{ $isPageActive ? 'active' : '' }}">
                        <span class="sidebar-icon">
                            @if ($page === 'dashboard')
                                <i class="fas fa-chart-simple"></i>
                            @elseif ($page === 'krs')
                                <i class="fas fa-clipboard-list"></i>
                            @elseif ($page === 'khs')
                                <i class="fas fa-file-lines"></i>
                            @elseif ($page === 'nilai')
                                <i class="fas fa-star-half-stroke"></i>
                            @elseif ($page === 'akun')
                                <i class="fas fa-user-gear"></i>
                            @elseif ($page === 'mahasiswa')
                                <i class="fas fa-users"></i>
                            @elseif ($page === 'dosen')
                                <i class="fas fa-chalkboard-user"></i>
                            @elseif ($page === 'mata-kuliah')
                                <i class="fas fa-book-open"></i>
                            @elseif ($page === 'semester')
                                <i class="fas fa-calendar-days"></i>
                            @elseif ($page === 'kelas-matkul')
                                <i class="fas fa-layer-group"></i>
                            @else
                                <span class="inline-block w-1 h-1 bg-stone-300"></span>
                            @endif
                        </span>
                        <span>{{ $label }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    @endforeach
</nav>

<div class="border-t border-stone-200 px-4 py-3">
    <a href="{{ url('/') }}" class="sidebar-link text-xs text-stone-400 hover:text-amber-700">
        <i class="sidebar-icon fas fa-external-link-alt"></i>
        <span>Buka Aplikasi</span>
    </a>
</div>
