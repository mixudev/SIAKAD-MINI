@extends('dashboard.layouts.main')

@section('content')
<div class="animate-fade-in">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-lg font-bold text-slate-900">Input Nilai</h1>
            <p class="text-sm text-slate-500">Pilih kelas untuk menginput nilai mahasiswa.</p>
        </div>
    </div>

    <div class="bg-white border border-slate-200 mb-6">
        <div class="px-4 py-3 border-b border-slate-100">
            <form method="GET" action="{{ route('dosen.nilai.index') }}">
                <div class="flex gap-3 items-end">
                    <div>
                        <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1 block">Semester</label>
                        <select name="semester_id" onchange="this.form.submit()" class="px-3 py-2 border border-slate-200 text-sm focus:outline-none focus:border-slate-900">
                            @foreach($semesters as $s)
                                <option value="{{ $s->id }}" {{ $s->id == $semesterId ? 'selected' : '' }}>{{ $s->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100">
                        <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Kode</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Mata Kuliah</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Kelas</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Semester</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Jadwal</th>
                        <th class="text-center px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Mahasiswa</th>
                        <th class="text-center px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($daftarKelas as $km)
                    <tr class="hover:bg-slate-50 transition-colors duration-150">
                        <td class="px-4 py-3 font-mono text-sm text-slate-900">{{ $km->mataKuliah->kode }}</td>
                        <td class="px-4 py-3 text-sm text-slate-700">{{ $km->mataKuliah->nama }}</td>
                        <td class="px-4 py-3 text-sm text-slate-600">{{ $km->nama_kelas }}</td>
                        <td class="px-4 py-3 text-sm text-slate-600">{{ $km->semester?->nama ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm text-slate-600">
                            @if ($km->hari && $km->jam_mulai)
                                {{ $km->hari }}, {{ \Carbon\Carbon::parse($km->jam_mulai)->format('H:i') }}-{{ \Carbon\Carbon::parse($km->jam_selesai)->format('H:i') }}
                            @else
                                <span class="text-slate-400">-</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-center text-sm text-slate-600">{{ $km->jumlahPeserta() }}</td>
                        <td class="px-4 py-3 text-center">
                            <a href="{{ route('dosen.nilai.edit', $km) }}"
                                class="inline-flex px-3 py-1.5 bg-slate-900 text-white text-xs font-bold tracking-wide hover:bg-slate-700 transition-colors duration-200">
                                Input Nilai
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-12 text-center text-sm text-slate-400">
                            Tidak ada kelas yang diampu untuk semester ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
