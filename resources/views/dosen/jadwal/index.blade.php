@extends('dashboard.layouts.main')

@section('content')
<div class="animate-fade-in">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-lg font-bold text-slate-900">Jadwal Mengajar</h1>
            <p class="text-sm text-slate-500">Jadwal kelas yang Anda ampu.</p>
        </div>
    </div>

    @if($semester)
        <div class="bg-white border border-slate-200 mb-6">
            <div class="p-4 border-b border-slate-100">
                <form method="GET" action="{{ route('dosen.jadwal.index') }}">
                    <div class="flex gap-3">
                        <select name="semester_id" onchange="this.form.submit()" class="px-3 py-2 border border-slate-200 text-sm focus:outline-none focus:border-slate-900">
                            @foreach($semesters as $s)
                                <option value="{{ $s->id }}" {{ $s->id == $semester->id ? 'selected' : '' }}>
                                    {{ $s->nama }} ({{ $s->tahun_ajaran }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
        </div>
    @endif

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
                                <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Ruangan</th>
                                <th class="text-right px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Mahasiswa</th>
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
            <p class="text-sm text-slate-400">Belum ada jadwal mengajar untuk semester ini.</p>
        </div>
    @endforelse

    @if($jadwal->isEmpty())
        <div class="bg-white border border-slate-200 p-8 text-center">
            <i class="fa-solid fa-calendar-xmark text-3xl text-slate-300 mb-3"></i>
            <p class="text-sm text-slate-400">Belum ada jadwal mengajar untuk semester ini.</p>
        </div>
    @endif
</div>
@endSection
