@extends('dashboard.layouts.main')

@section('content')
<div class="animate-fade-in">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-lg font-bold text-slate-900">Nilai Mahasiswa</h1>
            <p class="text-sm text-slate-500">Lihat seluruh nilai mahasiswa di semua kelas.</p>
        </div>
    </div>

    <div class="bg-white border border-slate-200 mb-6">
        <div class="px-4 py-3 border-b border-slate-100">
            <form method="GET" action="{{ route('admin.nilai.index') }}">
                <div class="flex gap-3 items-end">
                    <div>
                        <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1 block">Semester</label>
                        <select name="semester_id" onchange="this.form.submit()" class="px-3 py-2 border border-slate-200 text-sm focus:outline-none focus:border-slate-900">
                            @foreach($semesters as $s)
                                <option value="{{ $s->id }}" {{ $s->id == $semesterId ? 'selected' : '' }}>{{ $s->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1 block">Kelas</label>
                        <select name="kelas_matkul_id" onchange="this.form.submit()" class="px-3 py-2 border border-slate-200 text-sm focus:outline-none focus:border-slate-900">
                            <option value="">Semua Kelas</option>
                            @foreach($kelasMatkuls as $km)
                                <option value="{{ $km->id }}" {{ $km->id == $kelasFilter ? 'selected' : '' }}>
                                    {{ $km->mataKuliah->kode }} - {{ $km->mataKuliah->nama }} (Kelas {{ $km->nama_kelas }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @if($kelasFilter || $semesterId != $semesterAktifId)
                        <a href="{{ route('admin.nilai.index') }}" class="px-4 py-2 border border-slate-200 text-slate-600 text-xs font-bold tracking-wide hover:bg-slate-50 transition-colors duration-200">Reset</a>
                    @endif
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100">
                        <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">NIM</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Mahasiswa</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Mata Kuliah</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Kelas</th>
                        <th class="text-center px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Tugas</th>
                        <th class="text-center px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">UTS</th>
                        <th class="text-center px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">UAS</th>
                        <th class="text-center px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">NA</th>
                        <th class="text-center px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">NH</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($daftarNilai as $nilai)
                    <tr class="hover:bg-slate-50 transition-colors duration-150">
                        <td class="px-4 py-3 font-mono text-sm text-slate-900">{{ $nilai->mahasiswa->user->identifier }}</td>
                        <td class="px-4 py-3 text-sm text-slate-700">{{ $nilai->mahasiswa->nama_lengkap }}</td>
                        <td class="px-4 py-3 text-sm text-slate-600">{{ $nilai->kelasMatkul->mataKuliah->kode }} - {{ $nilai->kelasMatkul->mataKuliah->nama }}</td>
                        <td class="px-4 py-3 text-sm text-slate-600">{{ $nilai->kelasMatkul->nama_kelas }} - {{ $nilai->kelasMatkul->dosen->nama_lengkap }}</td>
                        <td class="px-4 py-3 text-center text-sm text-slate-600">{{ $nilai->nilai_tugas ?? '-' }}</td>
                        <td class="px-4 py-3 text-center text-sm text-slate-600">{{ $nilai->nilai_uts ?? '-' }}</td>
                        <td class="px-4 py-3 text-center text-sm text-slate-600">{{ $nilai->nilai_uas ?? '-' }}</td>
                        <td class="px-4 py-3 text-center text-sm font-semibold text-slate-900">{{ $nilai->nilai_akhir ?? '-' }}</td>
                        <td class="px-4 py-3 text-center">
                            @if($nilai->nilai_huruf)
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full text-xs font-bold {{ $nilai->nilai_huruf[0] >= 'C' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">{{ $nilai->nilai_huruf }}</span>
                            @else
                                <span class="text-slate-400">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="px-4 py-12 text-center text-sm text-slate-400">Belum ada data nilai.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
