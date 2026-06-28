@extends('dashboard.layouts.main')

@section('content')
@php
    $persen = $persentaseNilai['persen'];
    $terisi = $persentaseNilai['terisi'];
    $totalNilai = $persentaseNilai['total'];
@endphp
<div class="animate-fade-in">

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 lg:gap-6">
        <div class="bg-white border border-slate-200 p-5">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold tracking-wider text-slate-400 uppercase">Kelas Diampu</span>
                <span class="w-8 h-8 bg-indigo-50 flex items-center justify-center text-indigo-600">
                    <i class="fa-solid fa-chalkboard-user text-sm"></i>
                </span>
            </div>
            <p class="text-3xl font-bold text-slate-900">{{ $kelasCount }}</p>
            <p class="text-xs text-slate-500 mt-1">Semester ini</p>
        </div>

        <div class="bg-white border border-slate-200 p-5">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold tracking-wider text-slate-400 uppercase">Mahasiswa</span>
                <span class="w-8 h-8 bg-emerald-50 flex items-center justify-center text-emerald-600">
                    <i class="fa-solid fa-user-graduate text-sm"></i>
                </span>
            </div>
            <p class="text-3xl font-bold text-slate-900">{{ $totalMahasiswa }}</p>
            <p class="text-xs text-slate-500 mt-1">Total bimbingan</p>
        </div>

        <div class="bg-white border border-slate-200 p-5">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold tracking-wider text-slate-400 uppercase">Nilai</span>
                <span class="w-8 h-8 bg-amber-50 flex items-center justify-center text-amber-600">
                    <i class="fa-solid fa-star-half-stroke text-sm"></i>
                </span>
            </div>
            <p class="text-3xl font-bold text-slate-900">{{ $persen }}%</p>
            <p class="text-xs text-slate-500 mt-1">{{ $terisi }}/{{ $totalNilai }} sudah diinput</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-6 mt-6">
        <div class="bg-white border border-slate-200 p-5">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Rata-rata Nilai per Kelas</h3>
                <span class="text-xs text-slate-400">Semester ini</span>
            </div>
            <canvas id="chartRataNilai" height="200"></canvas>
        </div>

        <div class="bg-white border border-slate-200 p-5">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Progress Input Nilai</h3>
                <span class="text-xs text-slate-400">Terisi vs Belum</span>
            </div>
            <canvas id="chartNilaiProgress" height="200"></canvas>
        </div>
    </div>

    <div class="bg-white border border-slate-200 mt-6">
        <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
            <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Kelas Diampu Semester Ini</h3>
            <a href="{{ route('dosen.nilai.index') }}" class="text-xs text-indigo-600 hover:text-indigo-800 font-medium">Input Nilai &rarr;</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 text-left">
                        <th class="px-5 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Kelas</th>
                        <th class="px-5 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Mata Kuliah</th>
                        <th class="px-5 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Jadwal</th>
                        <th class="px-5 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Mahasiswa</th>
                        <th class="px-5 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Progress</th>
                        <th class="px-5 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($kelasList as $kelas)
                        <tr class="hover:bg-slate-50">
                            <td class="px-5 py-4 font-medium text-slate-900">Kelas {{ $kelas['nama_kelas'] }}</td>
                            <td class="px-5 py-4 text-slate-600">{{ $kelas['matkul'] }}</td>
                            <td class="px-5 py-4 text-slate-500 text-xs">{{ $kelas['hari'] }}, {{ $kelas['jam'] }}</td>
                            <td class="px-5 py-4 font-semibold text-slate-900">{{ $kelas['total_mahasiswa'] }}</td>
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-2">
                                    <div class="flex-1 h-2 bg-slate-100">
                                        <div class="h-full bg-indigo-500 transition-all" style="width: {{ $kelas['persen'] }}%"></div>
                                    </div>
                                    <span class="text-xs font-medium text-slate-500 min-w-[3rem] text-right">{{ $kelas['terisi'] }}/{{ $kelas['total_mahasiswa'] }}</span>
                                </div>
                            </td>
                            <td class="px-5 py-4 text-right">
                                <a href="{{ route('dosen.nilai.edit', $kelas['id']) }}" class="px-3 py-1.5 text-xs font-medium text-indigo-600 bg-indigo-50 hover:bg-indigo-100">Input</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-8 text-center text-sm text-slate-400">Belum ada kelas diampu untuk semester ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    Chart.defaults.font.family = "'Inter', system-ui, sans-serif";
    Chart.defaults.font.size = 11;
    Chart.defaults.color = '#94a3b8';

    const colorPrimary = '#6366f1';
    const colorAmber = '#f59e0b';

    const rataData = @json($rataNilai);
    if (document.getElementById('chartRataNilai') && rataData.length) {
        const labels = rataData.map(function (r) { return r.label; });
        const values = rataData.map(function (r) { return r.rata_rata; });

        new Chart(document.getElementById('chartRataNilai'), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Rata-rata NA',
                    data: values,
                    backgroundColor: values.map(function (v) {
                        if (v >= 80) return '#34d399';
                        if (v >= 70) return '#fbbf24';
                        return '#f87171';
                    }),
                    borderRadius: 4,
                    barThickness: 40,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                indexAxis: 'y',
                plugins: { legend: { display: false } },
                scales: {
                    x: { beginAtZero: true, max: 100, grid: { display: false } },
                    y: { grid: { display: false } }
                }
            }
        });
    }

    const progressData = @json($nilaiProgress);
    if (document.getElementById('chartNilaiProgress') && (progressData.terisi || progressData.belum)) {
        new Chart(document.getElementById('chartNilaiProgress'), {
            type: 'doughnut',
            data: {
                labels: ['Sudah Diinput', 'Belum Diinput'],
                datasets: [{
                    data: [progressData.terisi, progressData.belum],
                    backgroundColor: ['#34d399', '#e2e8f0'],
                    borderWidth: 0,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { usePointStyle: true, pointStyleWidth: 8, padding: 12 }
                    }
                },
                cutout: '65%',
            }
        });
    }
});
</script>
@endpush
