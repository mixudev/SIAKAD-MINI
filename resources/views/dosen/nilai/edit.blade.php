@extends('dashboard.layouts.main')

@section('content')
<div class="animate-fade-in" x-data="{ aiLoading: false, aiAnalysis: '', aiShow: false }">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-lg font-bold text-slate-900">Input Nilai</h1>
            <p class="text-sm text-slate-500">
                {{ $kelasMatkul->mataKuliah->kode }} - {{ $kelasMatkul->mataKuliah->nama }}
                (Kelas {{ $kelasMatkul->nama_kelas }}) — {{ $kelasMatkul->semester->nama }}
            </p>
        </div>
        <div class="flex items-center gap-2">
            <button
                type="button"
                @click="if(!aiAnalysis && !aiLoading) { aiLoading = true; fetch('{{ route('ai.analyze-grade', $kelasMatkul) }}').then(r => r.json()).then(d => { aiAnalysis = d.analysis; aiShow = true; aiLoading = false; }).catch(() => { aiLoading = false; alert('Gagal memuat analisis.'); }); } else { aiShow = !aiShow; }"
                class="px-4 py-2 bg-indigo-600 text-white text-xs font-bold tracking-wide hover:bg-indigo-700 transition-colors duration-200"
            >
                <i class="fa-solid fa-wand-magic-sparkles mr-1.5"></i>
                <span x-text="aiLoading ? 'Menganalisis...' : 'Analisis dengan AI'"></span>
            </button>
            <a href="{{ route('dosen.nilai.index') }}" class="px-4 py-2 border border-slate-200 text-slate-600 text-xs font-bold tracking-wide hover:bg-slate-50 transition-colors duration-200">
                Kembali
            </a>
        </div>
    </div>

    <div
        x-show="aiShow"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-cloak
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
    >
        <div class="bg-white max-w-lg w-full mx-4 shadow-2xl">
            <div class="bg-gradient-to-r from-indigo-600 to-indigo-800 px-5 py-4 flex items-center justify-between">
                <h3 class="text-sm font-bold text-white uppercase tracking-wider">Analisis AI</h3>
                <button @click="aiShow = false" class="text-white/50 hover:text-white">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>
            <div class="p-5">
                <div x-show="aiLoading" class="flex items-center gap-2 text-slate-500">
                    <i class="fa-solid fa-spinner fa-spin"></i>
                    <span class="text-sm">Menganalisis data nilai...</span>
                </div>
                <p x-show="!aiLoading" class="text-sm text-slate-700 leading-relaxed whitespace-pre-line" x-text="aiAnalysis"></p>
            </div>
        </div>
    </div>

    <div class="bg-white border border-slate-200">
        <form method="POST" action="{{ route('dosen.nilai.update', $kelasMatkul) }}">
            @csrf
            @method('PUT')
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100">
                            <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider w-12">No</th>
                            <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">NIM</th>
                            <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Nama</th>
                            <th class="text-center px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Tugas (30%)</th>
                            <th class="text-center px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">UTS (30%)</th>
                            <th class="text-center px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">UAS (40%)</th>
                            <th class="text-center px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">NA</th>
                            <th class="text-center px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">NH</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($daftarNilai as $index => $nilai)
                        <tr class="hover:bg-slate-50 transition-colors duration-150">
                            <td class="px-4 py-3 text-sm text-slate-600 text-center">{{ $loop->iteration }}</td>
                            <td class="px-4 py-3 font-mono text-sm text-slate-900">{{ $nilai->mahasiswa->user->identifier }}</td>
                            <td class="px-4 py-3 text-sm text-slate-700">{{ $nilai->mahasiswa->nama_lengkap }}</td>
                            <td class="px-4 py-3 text-center">
                                <input type="number" name="nilai[{{ $nilai->mahasiswa_id }}][nilai_tugas]" value="{{ $nilai->nilai_tugas }}"
                                    class="w-20 text-center px-2 py-1.5 border border-slate-200 text-sm focus:outline-none focus:border-slate-900 nilai-input"
                                    min="0" max="100" step="0.01" data-id="{{ $nilai->id }}">
                            </td>
                            <td class="px-4 py-3 text-center">
                                <input type="number" name="nilai[{{ $nilai->mahasiswa_id }}][nilai_uts]" value="{{ $nilai->nilai_uts }}"
                                    class="w-20 text-center px-2 py-1.5 border border-slate-200 text-sm focus:outline-none focus:border-slate-900 nilai-input"
                                    min="0" max="100" step="0.01" data-id="{{ $nilai->id }}">
                            </td>
                            <td class="px-4 py-3 text-center">
                                <input type="number" name="nilai[{{ $nilai->mahasiswa_id }}][nilai_uas]" value="{{ $nilai->nilai_uas }}"
                                    class="w-20 text-center px-2 py-1.5 border border-slate-200 text-sm focus:outline-none focus:border-slate-900 nilai-input"
                                    min="0" max="100" step="0.01" data-id="{{ $nilai->id }}">
                            </td>
                            <td class="px-4 py-3 text-center font-semibold text-slate-900 nilai-akhir">
                                {{ $nilai->nilai_akhir ?? '-' }}
                            </td>
                            <td class="px-4 py-3 text-center font-bold nilai-huruf">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full {{ $nilai->nilai_huruf && $nilai->nilai_huruf[0] >= 'C' ? 'bg-emerald-100 text-emerald-700' : ($nilai->nilai_huruf ? 'bg-red-100 text-red-700' : 'bg-slate-100 text-slate-400') }}">
                                    {{ $nilai->nilai_huruf ?? '-' }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-4 py-12 text-center text-sm text-slate-400">
                                Belum ada mahasiswa terdaftar di kelas ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($daftarNilai->isNotEmpty())
            <div class="px-4 py-3 border-t border-slate-100 flex items-center justify-end">
                <button type="submit" class="px-6 py-2.5 bg-slate-900 text-white text-xs font-bold tracking-wide hover:bg-slate-700 transition-colors duration-200">
                    Simpan Semua Nilai
                </button>
            </div>
            @endif
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
const BOBOT_TUGAS = 0.30;
const BOBOT_UTS = 0.30;
const BOBOT_UAS = 0.40;

const KONVERSI_HURUF = [
    { min: 85, huruf: 'A' },
    { min: 80, huruf: 'A-' },
    { min: 75, huruf: 'B+' },
    { min: 70, huruf: 'B' },
    { min: 65, huruf: 'B-' },
    { min: 60, huruf: 'C+' },
    { min: 55, huruf: 'C' },
    { min: 40, huruf: 'D' },
    { min: 0, huruf: 'E' },
];

function hitungNilaiAkhir(tugas, uts, uas) {
    return (tugas * BOBOT_TUGAS) + (uts * BOBOT_UTS) + (uas * BOBOT_UAS);
}

function konversiHuruf(nilai) {
    if (nilai === null || isNaN(nilai)) return null;
    for (const k of KONVERSI_HURUF) {
        if (nilai >= k.min) return k.huruf;
    }
    return 'E';
}

document.querySelectorAll('.nilai-input').forEach(input => {
    input.addEventListener('input', function() {
        const tr = this.closest('tr');
        const inputs = tr.querySelectorAll('.nilai-input');
        const tugas = parseFloat(inputs[0].value) || 0;
        const uts = parseFloat(inputs[1].value) || 0;
        const uas = parseFloat(inputs[2].value) || 0;

        const na = hitungNilaiAkhir(tugas, uts, uas);
        const nh = konversiHuruf(na);

        tr.querySelector('.nilai-akhir').textContent = na.toFixed(2);
        const span = tr.querySelector('.nilai-huruf span');
        if (nh) {
            span.textContent = nh;
            span.className = 'inline-flex items-center justify-center w-8 h-8 rounded-full ' +
                (nh[0] >= 'C' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700');
        }
    });
});
</script>
@endpush
