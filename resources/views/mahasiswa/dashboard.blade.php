@extends('dashboard.layouts.main')

@section('content')
<div class="animate-fade-in">

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 lg:gap-6">
        <div class="bg-white border border-slate-200 p-5">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold tracking-wider text-slate-400 uppercase">SKS Diambil</span>
                <span class="w-8 h-8 bg-indigo-50 flex items-center justify-center text-indigo-600">
                    <i class="fa-solid fa-clipboard-list text-sm"></i>
                </span>
            </div>
            <p class="text-3xl font-bold text-slate-900">{{ $sksDiambil }}</p>
            <p class="text-xs text-slate-500 mt-1">Semester berjalan</p>
        </div>

        <div class="bg-white border border-slate-200 p-5">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold tracking-wider text-slate-400 uppercase">IP Semester</span>
                <span class="w-8 h-8 bg-emerald-50 flex items-center justify-center text-emerald-600">
                    <i class="fa-solid fa-star-half-stroke text-sm"></i>
                </span>
            </div>
            <p class="text-3xl font-bold text-slate-900">{{ $ipSemester ? number_format($ipSemester, 2) : '-' }}</p>
            <p class="text-xs text-slate-500 mt-1">Semester berjalan</p>
        </div>

        <div class="bg-white border border-slate-200 p-5">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold tracking-wider text-slate-400 uppercase">IP Kumulatif</span>
                <span class="w-8 h-8 bg-amber-50 flex items-center justify-center text-amber-600">
                    <i class="fa-solid fa-trophy text-sm"></i>
                </span>
            </div>
            <p class="text-3xl font-bold text-slate-900">{{ number_format($ipk, 2) }}</p>
            <p class="text-xs text-slate-500 mt-1">Seluruh semester</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-6 mt-6">
        <div class="bg-white border border-slate-200 p-5">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Tren IP per Semester</h3>
                <span class="text-xs text-slate-400">Performa akademik</span>
            </div>
            <canvas id="chartIpTrend" height="200"></canvas>
        </div>

        <div class="bg-white border border-slate-200 p-5">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider">SKS per Semester</h3>
                <span class="text-xs text-slate-400">Beban studi</span>
            </div>
            <canvas id="chartSksTrend" height="200"></canvas>
        </div>
    </div>

    <div class="bg-white border border-slate-200 mt-6">
        <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
            <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Nilai Semester Ini</h3>
            <a href="{{ route('mahasiswa.khs.index') }}" class="text-xs text-indigo-600 hover:text-indigo-800 font-medium">Lihat KHS &rarr;</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 text-left">
                        <th class="px-5 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Mata Kuliah</th>
                        <th class="px-5 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">SKS</th>
                        <th class="px-5 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider text-right">Nilai Akhir</th>
                        <th class="px-5 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider text-right">Nilai Huruf</th>
                        <th class="px-5 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider text-right">Bobot Mutu</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($nilaiSemesterIni as $nilai)
                        <tr class="hover:bg-slate-50">
                            <td class="px-5 py-4 font-medium text-slate-900">{{ $nilai->kelasMatkul->mataKuliah->nama }}</td>
                            <td class="px-5 py-4 text-slate-600">{{ $nilai->kelasMatkul->mataKuliah->sks }}</td>
                            <td class="px-5 py-4 text-right font-semibold text-slate-900">{{ number_format($nilai->nilai_akhir, 2) }}</td>
                            <td class="px-5 py-4 text-right">
                                <span class="inline-flex px-2 py-0.5 text-xs font-semibold bg-indigo-50 text-indigo-700">{{ $nilai->nilai_huruf }}</span>
                            </td>
                            <td class="px-5 py-4 text-right font-medium text-slate-700">{{ number_format($nilai->bobotMutu(), 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-8 text-center text-sm text-slate-400">Belum ada nilai untuk semester ini.</td>
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
    const colorPrimaryLight = 'rgba(99, 102, 241, 0.15)';
    const colorAmber = '#f59e0b';
    const colorAmberLight = 'rgba(245, 158, 11, 0.15)';

    const ipData = @json($ipTrend);
    if (document.getElementById('chartIpTrend') && ipData.length) {
        const labels = ipData.map(function (r) { return r.semester; });
        const values = ipData.map(function (r) { return r.ip; });

        new Chart(document.getElementById('chartIpTrend'), {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'IP',
                    data: values,
                    borderColor: colorPrimary,
                    backgroundColor: colorPrimaryLight,
                    fill: true,
                    tension: 0.35,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    borderWidth: 2,
                    pointBackgroundColor: colorPrimary,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: { legend: { display: false } },
                scales: {
                    x: { grid: { display: false } },
                    y: { beginAtZero: true, max: 4.0, ticks: { stepSize: 1.0 } }
                }
            }
        });
    }

    const sksData = @json($sksTrend);
    if (document.getElementById('chartSksTrend') && sksData.length) {
        const labels = sksData.map(function (r) { return r.semester; });
        const values = sksData.map(function (r) { return r.sks; });

        new Chart(document.getElementById('chartSksTrend'), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'SKS',
                    data: values,
                    backgroundColor: colorAmber,
                    borderRadius: 4,
                    barThickness: 32,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: { legend: { display: false } },
                scales: {
                    x: { grid: { display: false } },
                    y: { beginAtZero: true, ticks: { precision: 0 } }
                }
            }
        });
    }
});
</script>
@endpush
