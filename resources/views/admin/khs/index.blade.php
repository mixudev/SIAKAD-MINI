@extends('dashboard.layouts.main')

@section('content')
<div class="animate-fade-in">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-lg font-bold text-slate-900">KHS Mahasiswa</h1>
            <p class="text-sm text-slate-500">Lihat Kartu Hasil Studi mahasiswa.</p>
        </div>
    </div>

    <div class="bg-white border border-slate-200 mb-6">
        <div class="px-4 py-3 border-b border-slate-100">
            <form method="GET" action="{{ route('admin.khs.index') }}">
                <div class="flex gap-3 items-end">
                    <div>
                        <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1 block">Mahasiswa</label>
                        <select name="mahasiswa_id" class="px-3 py-2 border border-slate-200 text-sm focus:outline-none focus:border-slate-900" onchange="this.form.submit()">
                            <option value="">Pilih Mahasiswa</option>
                            @foreach($mahasiswas as $mhs)
                                <option value="{{ $mhs->id }}" {{ $mhs->id == $mahasiswaId ? 'selected' : '' }}>
                                    {{ $mhs->nim }} - {{ $mhs->nama_lengkap }} ({{ $mhs->program_studi }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1 block">Semester</label>
                        <select name="semester_id" class="px-3 py-2 border border-slate-200 text-sm focus:outline-none focus:border-slate-900" onchange="this.form.submit()">
                            <option value="">Pilih Semester</option>
                            @foreach($semesters as $s)
                                <option value="{{ $s->id }}" {{ $s->id == $semesterId ? 'selected' : '' }}>{{ $s->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </form>
        </div>

        @if ($selectedMahasiswa && $selectedSemester)
            <div class="px-4 py-3 border-b border-slate-100 bg-slate-50">
                <div class="flex items-center gap-6">
                    <div><span class="text-xs font-semibold text-slate-500 uppercase">NIM</span><p class="text-sm font-semibold text-slate-900">{{ $selectedMahasiswa->nim }}</p></div>
                    <div><span class="text-xs font-semibold text-slate-500 uppercase">Nama</span><p class="text-sm font-semibold text-slate-900">{{ $selectedMahasiswa->nama_lengkap }}</p></div>
                    <div><span class="text-xs font-semibold text-slate-500 uppercase">Prodi</span><p class="text-sm text-slate-700">{{ $selectedMahasiswa->program_studi }}</p></div>
                    <div><span class="text-xs font-semibold text-slate-500 uppercase">Semester</span><p class="text-sm text-slate-700">{{ $selectedSemester->nama }}</p></div>
                </div>
            </div>

            @if($daftarNilai->isNotEmpty())
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100">
                            <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider w-12">No</th>
                            <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Kode MK</th>
                            <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Mata Kuliah</th>
                            <th class="text-center px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">SKS</th>
                            <th class="text-center px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Tugas</th>
                            <th class="text-center px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">UTS</th>
                            <th class="text-center px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">UAS</th>
                            <th class="text-center px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">NA</th>
                            <th class="text-center px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">NH</th>
                            <th class="text-center px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Bobot</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($daftarNilai as $nilai)
                        <tr class="hover:bg-slate-50 transition-colors duration-150">
                            <td class="px-4 py-3 text-sm text-slate-600 text-center">{{ $loop->iteration }}</td>
                            <td class="px-4 py-3 font-mono text-sm text-slate-900">{{ $nilai->kelasMatkul->mataKuliah->kode }}</td>
                            <td class="px-4 py-3 text-sm text-slate-700">{{ $nilai->kelasMatkul->mataKuliah->nama }}</td>
                            <td class="px-4 py-3 text-center text-sm font-semibold text-slate-900">{{ $nilai->kelasMatkul->mataKuliah->sks }}</td>
                            <td class="px-4 py-3 text-center text-sm text-slate-600">{{ $nilai->nilai_tugas ?? '-' }}</td>
                            <td class="px-4 py-3 text-center text-sm text-slate-600">{{ $nilai->nilai_uts ?? '-' }}</td>
                            <td class="px-4 py-3 text-center text-sm text-slate-600">{{ $nilai->nilai_uas ?? '-' }}</td>
                            <td class="px-4 py-3 text-center text-sm font-semibold text-slate-900">{{ $nilai->nilai_akhir ?? '-' }}</td>
                            <td class="px-4 py-3 text-center">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full text-xs font-bold {{ $nilai->nilai_huruf && $nilai->nilai_huruf[0] >= 'C' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">{{ $nilai->nilai_huruf ?? '-' }}</span>
                            </td>
                            <td class="px-4 py-3 text-center text-sm font-semibold text-slate-900">{{ number_format($nilai->bobotMutu(), 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-4 py-4 border-t border-slate-100 bg-slate-50 flex justify-end gap-8">
                <div class="text-right">
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">IP Semester</p>
                    <p class="text-2xl font-bold text-slate-900">{{ $ipSemester ? number_format($ipSemester, 2) : '-' }}</p>
                </div>
                <div class="text-right">
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">IP Kumulatif</p>
                    <p class="text-2xl font-bold text-slate-900">{{ $ipk ? number_format($ipk, 2) : '-' }}</p>
                </div>
            </div>
            @else
            <div class="px-4 py-12 text-center text-sm text-slate-400">Belum ada nilai untuk mahasiswa ini di semester yang dipilih.</div>
            @endif

            @if ($transkrip->isNotEmpty())
            <div class="border-t border-slate-100">
                <div class="px-4 py-3 bg-slate-50 border-b border-slate-100">
                    <h3 class="text-sm font-bold text-slate-900">Transkrip Akademik</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-slate-50">
                                <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Semester</th>
                                <th class="text-right px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">IP Semester</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($transkrip as $t)
                            <tr class="hover:bg-slate-50 transition-colors duration-150">
                                <td class="px-4 py-3 text-sm text-slate-700">{{ $t['semester']->nama }}</td>
                                <td class="px-4 py-3 text-right text-sm font-bold text-slate-900">{{ $t['ip'] ? number_format($t['ip'], 2) : '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-slate-50 border-t border-slate-100">
                            <tr>
                                <td class="px-4 py-3 text-sm font-bold text-slate-900">IP Kumulatif</td>
                                <td class="px-4 py-3 text-right text-sm font-bold text-slate-900">{{ $ipk ? number_format($ipk, 2) : '-' }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            @endif
        @else
            <div class="px-4 py-12 text-center text-sm text-slate-400">Pilih mahasiswa dan semester untuk melihat KHS.</div>
        @endif
    </div>
</div>
@endsection
