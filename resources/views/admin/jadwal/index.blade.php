@extends('dashboard.layouts.main')

@section('content')
<div class="animate-fade-in">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-lg font-bold text-slate-900">Jadwal Perkuliahan</h1>
            <p class="text-sm text-slate-500">Semua jadwal kelas mata kuliah aktif.</p>
        </div>
    </div>

    <div class="bg-white border border-slate-200 mb-6">
        <div class="p-4 border-b border-slate-100">
            <form method="GET" action="{{ route('admin.jadwal.index') }}">
                <div class="flex flex-wrap gap-3">
                    <select name="semester_id" class="px-3 py-2 border border-slate-200 text-sm focus:outline-none focus:border-slate-900">
                        @foreach($semesters as $s)
                            <option value="{{ $s->id }}" {{ $s->id == $semester->id ? 'selected' : '' }}>
                                {{ $s->nama }} ({{ $s->tahun_ajaran }})
                            </option>
                        @endforeach
                    </select>
                    <select name="dosen_id" class="px-3 py-2 border border-slate-200 text-sm focus:outline-none focus:border-slate-900">
                        <option value="">Semua Dosen</option>
                        @foreach($dosens as $d)
                            <option value="{{ $d->id }}" {{ request('dosen_id') == $d->id ? 'selected' : '' }}>
                                {{ $d->nama_lengkap }}
                            </option>
                        @endforeach
                    </select>
                    <select name="hari" class="px-3 py-2 border border-slate-200 text-sm focus:outline-none focus:border-slate-900">
                        <option value="">Semua Hari</option>
                        @foreach($daftarHari as $hari)
                            <option value="{{ $hari }}" {{ request('hari') === $hari ? 'selected' : '' }}>
                                {{ $hari }}
                            </option>
                        @endforeach
                    </select>
                    <input type="text" name="ruangan" value="{{ request('ruangan') }}" placeholder="Cari ruangan..." class="px-3 py-2 border border-slate-200 text-sm focus:outline-none focus:border-slate-900 w-40">
                    <button type="submit" class="px-4 py-2 bg-slate-900 text-white text-xs font-bold tracking-wide hover:bg-slate-700 transition-colors duration-200">Filter</button>
                    @if(request()->anyFilled(['dosen_id', 'hari', 'ruangan']))
                        <a href="{{ route('admin.jadwal.index', ['semester_id' => $semester->id]) }}" class="px-4 py-2 border border-slate-200 text-slate-600 text-xs font-bold tracking-wide hover:bg-slate-50 transition-colors duration-200">Reset</a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    @forelse($daftarHari as $hari)
        @php $kelasHariIni = $jadwal->where('hari', $hari); @endphp
        @if($kelasHariIni->isNotEmpty())
            <div class="bg-white border border-slate-200 mb-4">
                <div class="px-5 py-3 border-b border-slate-100 bg-slate-50">
                    <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider">{{ $hari }}</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-100">
                                <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider w-24">Jam</th>
                                <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Mata Kuliah</th>
                                <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Kelas</th>
                                <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Dosen</th>
                                <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Ruangan</th>
                                <th class="text-right px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Peserta</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($kelasHariIni as $km)
                                <tr class="hover:bg-slate-50 transition-colors duration-150">
                                    <td class="px-4 py-3 font-mono text-xs text-slate-600 whitespace-nowrap">
                                        {{ substr($km->jam_mulai, 0, 5) }} - {{ substr($km->jam_selesai, 0, 5) }}
                                    </td>
                                    <td class="px-4 py-3 font-medium text-slate-900">{{ $km->mataKuliah?->nama ?? '-' }}</td>
                                    <td class="px-4 py-3 text-slate-600">{{ $km->nama_kelas }}</td>
                                    <td class="px-4 py-3 text-slate-600">{{ $km->dosen?->nama_lengkap ?? '-' }}</td>
                                    <td class="px-4 py-3 text-slate-600">{{ $km->ruangan ?? '-' }}</td>
                                    <td class="px-4 py-3 text-right text-sm text-slate-600">
                                        {{ $km->jumlahPeserta() }} / {{ $km->kapasitas }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    @empty
        <div class="bg-white border border-slate-200 p-8 text-center">
            <i class="fa-solid fa-calendar-xmark text-3xl text-slate-300 mb-3"></i>
            <p class="text-sm text-slate-400">Belum ada jadwal perkuliahan untuk semester ini.</p>
        </div>
    @endforelse

    @if($jadwal->isEmpty())
        <div class="bg-white border border-slate-200 p-8 text-center">
            <i class="fa-solid fa-calendar-xmark text-3xl text-slate-300 mb-3"></i>
            <p class="text-sm text-slate-400">Belum ada jadwal perkuliahan untuk semester ini.</p>
        </div>
    @endif
</div>
@endSection
