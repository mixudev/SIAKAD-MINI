@extends('dashboard.layouts.main')

@section('content')
<div class="animate-fade-in">

    <x-ai.insight-box />

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6">
        <div class="bg-white border border-slate-200 p-5">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold tracking-wider text-slate-400 uppercase">Mahasiswa</span>
                <span class="w-8 h-8 bg-indigo-50 flex items-center justify-center text-indigo-600">
                    <i class="fa-solid fa-user-graduate text-sm"></i>
                </span>
            </div>
            <p class="text-3xl font-bold text-slate-900">{{ $statMahasiswa }}</p>
            <p class="text-xs text-slate-500 mt-1">Total terdaftar</p>
        </div>

        <div class="bg-white border border-slate-200 p-5">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold tracking-wider text-slate-400 uppercase">Dosen</span>
                <span class="w-8 h-8 bg-emerald-50 flex items-center justify-center text-emerald-600">
                    <i class="fa-solid fa-chalkboard-user text-sm"></i>
                </span>
            </div>
            <p class="text-3xl font-bold text-slate-900">{{ $statDosen }}</p>
            <p class="text-xs text-slate-500 mt-1">Total aktif</p>
        </div>

        <div class="bg-white border border-slate-200 p-5">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold tracking-wider text-slate-400 uppercase">Mata Kuliah</span>
                <span class="w-8 h-8 bg-amber-50 flex items-center justify-center text-amber-600">
                    <i class="fa-solid fa-book-open text-sm"></i>
                </span>
            </div>
            <p class="text-3xl font-bold text-slate-900">{{ $statMatkulAktif }}</p>
            <p class="text-xs text-slate-500 mt-1">Matkul aktif</p>
        </div>

        <div class="bg-white border border-slate-200 p-5">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold tracking-wider text-slate-400 uppercase">KRS Menunggu</span>
                <span class="w-8 h-8 bg-rose-50 flex items-center justify-center text-rose-600">
                    <i class="fa-solid fa-clock text-sm"></i>
                </span>
            </div>
            <p class="text-3xl font-bold text-slate-900">{{ $krsMenunggu }}</p>
            <p class="text-xs text-slate-500 mt-1">Perlu disetujui</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-4 lg:gap-6 mt-6">
        <div class="bg-white border border-slate-200 p-5">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Tren Pengajuan KRS</h3>
                <span class="text-xs text-slate-400">30 hari terakhir</span>
            </div>
            <canvas id="chartKrsTrend" height="200"></canvas>
        </div>

        <div class="bg-white border border-slate-200 p-5">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Distribusi Nilai</h3>
                <span class="text-xs text-slate-400">Semua kelas</span>
            </div>
            <canvas id="chartGradeDistribution" height="200"></canvas>
        </div>

        <div class="bg-white border border-slate-200 p-5">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Mahasiswa per Prodi</h3>
                <span class="text-xs text-slate-400">Program studi</span>
            </div>
            <canvas id="chartMahasiswaPerProdi" height="200"></canvas>
        </div>
    </div>

    <div class="bg-white border border-slate-200 mt-6">
        <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
            <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider">KRS Terbaru Menunggu Persetujuan</h3>
            <a href="{{ route('admin.krs.index') }}" class="text-xs text-indigo-600 hover:text-indigo-800 font-medium">Lihat Semua &rarr;</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 text-left">
                        <th class="px-5 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">NIM</th>
                        <th class="px-5 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Mahasiswa</th>
                        <th class="px-5 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Semester</th>
                        <th class="px-5 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">SKS</th>
                        <th class="px-5 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Diajukan</th>
                        <th class="px-5 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($recentKrs as $krs)
                        <tr class="hover:bg-slate-50">
                            <td class="px-5 py-4 font-mono text-xs text-slate-600">{{ $krs->mahasiswa->nim }}</td>
                            <td class="px-5 py-4 font-medium text-slate-900">{{ $krs->mahasiswa->nama_lengkap }}</td>
                            <td class="px-5 py-4 text-slate-600">{{ $krs->semester?->nama }}</td>
                            <td class="px-5 py-4 font-semibold text-slate-900">{{ $krs->total_sks }}</td>
                            <td class="px-5 py-4 text-slate-500 text-xs">{{ $krs->diajukan_at?->isoFormat('D MMM YYYY') }}</td>
                            <td class="px-5 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <form action="{{ route('admin.krs.approve', $krs) }}" method="POST" class="inline">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="px-3 py-1.5 text-xs font-medium text-white bg-emerald-600 hover:bg-emerald-700">Setujui</button>
                                    </form>
                                    <form action="{{ route('admin.krs.tolak', $krs) }}" method="POST" class="inline">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="px-3 py-1.5 text-xs font-medium text-white bg-rose-600 hover:bg-rose-700">Tolak</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-8 text-center text-sm text-slate-400">Tidak ada KRS yang menunggu persetujuan.</td>
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
    const colorEmber = '#f59e0b';
    const colorRose = '#f43f5e';

    const krsData = @json($krsTrend);
    if (document.getElementById('chartKrsTrend')) {
        const labels = [];
        const counts = [];
        const last30 = [];
        for (let i = 29; i >= 0; i--) {
            const d = new Date();
            d.setDate(d.getDate() - i);
            const ds = d.toISOString().slice(0, 10);
            last30.push(ds);
        }
        const dataMap = {};
        krsData.forEach(function (item) {
            dataMap[item.date.slice(0, 10)] = item.count;
        });
        last30.forEach(function (d) {
            const parts = d.split('-');
            labels.push(parts[2] + '/' + parts[1]);
            counts.push(dataMap[d] || 0);
        });

        new Chart(document.getElementById('chartKrsTrend'), {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Pengajuan',
                    data: counts,
                    borderColor: colorPrimary,
                    backgroundColor: colorPrimaryLight,
                    fill: true,
                    tension: 0.35,
                    pointRadius: 2,
                    pointHoverRadius: 5,
                    borderWidth: 2,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: { legend: { display: false } },
                scales: {
                    x: { grid: { display: false }, ticks: { maxTicksLimit: 10 } },
                    y: { beginAtZero: true, ticks: { precision: 0 } }
                }
            }
        });
    }

    const gradeData = @json($gradeDistribution);
    if (document.getElementById('chartGradeDistribution') && gradeData.length) {
        const gradeLabels = gradeData.map(function (g) { return g.nilai_huruf; });
        const gradeCounts = gradeData.map(function (g) { return g.total; });
        const gradeColors = ['#6366f1','#818cf8','#a78bfa','#c4b5fd','#34d399','#fbbf24','#fb923c','#f87171','#ef4444'];

        new Chart(document.getElementById('chartGradeDistribution'), {
            type: 'bar',
            data: {
                labels: gradeLabels,
                datasets: [{
                    label: 'Jumlah',
                    data: gradeCounts,
                    backgroundColor: gradeColors.slice(0, gradeLabels.length),
                    borderRadius: 4,
                    barThickness: 24,
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

    const prodiData = @json($mahasiswaPerProdi);
    if (document.getElementById('chartMahasiswaPerProdi') && prodiData.length) {
        const prodiLabels = prodiData.map(function (p) { return p.program_studi; });
        const prodiCounts = prodiData.map(function (p) { return p.total; });
        const prodiColors = ['#6366f1', '#34d399', '#fbbf24', '#fb923c', '#f472b6', '#38bdf8'];

        new Chart(document.getElementById('chartMahasiswaPerProdi'), {
            type: 'doughnut',
            data: {
                labels: prodiLabels,
                datasets: [{
                    data: prodiCounts,
                    backgroundColor: prodiColors.slice(0, prodiLabels.length),
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
