@extends('dashboard.layouts.main')

@section('content')
<div class="animate-fade-in">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-lg font-bold text-slate-900">Kartu Rencana Studi (KRS)</h1>
            <p class="text-sm text-slate-500">
                Semester: <span class="font-semibold text-slate-700">{{ $semester?->nama ?? '-' }}</span>
                @if ($semester?->krs_sedang_dibuka)
                    <span class="inline-flex items-center gap-1 ml-2 text-xs font-semibold text-emerald-600">
                        <span class="w-1.5 h-1.5 bg-emerald-500"></span>
                    Periode Pengisian
                    </span>
                @endif
            </p>
        </div>
    </div>

    @if (! $semester)
        <div class="bg-white border border-slate-200 p-6">
            <p class="text-sm text-slate-500">Tidak ada semester aktif saat ini.</p>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white border border-slate-200">
                    <div class="px-4 py-3 border-b border-slate-100">
                        <h2 class="text-sm font-bold text-slate-900">Daftar Kelas Tersedia</h2>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="bg-slate-50 border-b border-slate-100">
                                    <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Kode</th>
                                    <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Mata Kuliah</th>
                                    <th class="text-center px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">SKS</th>
                                    <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Dosen</th>
                                    <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Jadwal</th>
                                    <th class="text-center px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Kuota</th>
                                    <th class="text-center px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($kelasTersedia as $km)
                                <tr class="hover:bg-slate-50 transition-colors duration-150">
                                    <td class="px-4 py-3 font-mono text-sm text-slate-900">{{ $km->mataKuliah->kode }}</td>
                                    <td class="px-4 py-3 text-sm text-slate-700">{{ $km->mataKuliah->nama }}</td>
                                    <td class="px-4 py-3 text-center text-sm font-semibold text-slate-900">{{ $km->mataKuliah->sks }}</td>
                                    <td class="px-4 py-3 text-sm text-slate-600">{{ $km->dosen->nama_lengkap }}</td>
                                    <td class="px-4 py-3 text-sm text-slate-600">
                                        @if ($km->hari && $km->jam_mulai)
                                            {{ $km->hari }}, {{ \Carbon\Carbon::parse($km->jam_mulai)->format('H:i') }}-{{ \Carbon\Carbon::parse($km->jam_selesai)->format('H:i') }}
                                        @else
                                            <span class="text-slate-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-center text-sm text-slate-600">
                                        {{ $km->jumlahPeserta() }}/{{ $km->kapasitas }}
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        @if ($krs->status === 'draft')
                                            <form method="POST" action="{{ route('mahasiswa.krs.tambah', $km) }}" class="inline">
                                                @csrf
                                                <button type="submit" onclick="return confirmAction(event, 'Tambah Mata Kuliah', 'Tambahkan {{ $km->mataKuliah->nama }} - Kelas {{ $km->nama_kelas }} ke KRS?')"
                                                    class="px-3 py-1.5 bg-slate-900 text-white text-xs font-bold tracking-wide hover:bg-slate-700 transition-colors duration-200">
                                                    Tambah
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-xs text-slate-400">-</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-12 text-center text-sm text-slate-400">
                                        @if ($krs->status !== 'draft' && $krs->details->count() > 0)
                                            Semua kelas sudah diambil atau KRS sudah diajukan.
                                        @else
                                            Tidak ada kelas tersedia untuk semester ini.
                                        @endif
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="bg-white border border-slate-200">
                    <div class="px-4 py-3 border-b border-slate-100 flex items-center justify-between">
                        <h2 class="text-sm font-bold text-slate-900">Rincian KRS</h2>
                        @if ($krs->status === 'draft')
                            <span class="inline-flex items-center gap-1 text-xs font-semibold text-amber-600">
                                <span class="w-1.5 h-1.5 bg-amber-500"></span>
                                Draft
                            </span>
                        @elseif ($krs->status === 'diajukan')
                            <span class="inline-flex items-center gap-1 text-xs font-semibold text-blue-600">
                                <span class="w-1.5 h-1.5 bg-blue-500"></span>
                                Diajukan
                            </span>
                        @elseif ($krs->status === 'disetujui')
                            <span class="inline-flex items-center gap-1 text-xs font-semibold text-emerald-600">
                                <span class="w-1.5 h-1.5 bg-emerald-500"></span>
                                Disetujui
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 text-xs font-semibold text-red-600">
                                <span class="w-1.5 h-1.5 bg-red-500"></span>
                                Ditolak
                            </span>
                        @endif
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="bg-slate-50 border-b border-slate-100">
                                    <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Kode</th>
                                    <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Mata Kuliah</th>
                                    <th class="text-center px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">SKS</th>
                                    <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Kelas</th>
                                    <th class="text-center px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($krs->details as $detail)
                                <tr class="hover:bg-slate-50 transition-colors duration-150">
                                    <td class="px-4 py-3 font-mono text-sm text-slate-900">{{ $detail->kelasMatkul->mataKuliah->kode }}</td>
                                    <td class="px-4 py-3 text-sm text-slate-700">{{ $detail->kelasMatkul->mataKuliah->nama }}</td>
                                    <td class="px-4 py-3 text-center text-sm font-semibold text-slate-900">{{ $detail->sks_diambil }}</td>
                                    <td class="px-4 py-3 text-sm text-slate-600">{{ $detail->kelasMatkul->nama_kelas }} - {{ $detail->kelasMatkul->dosen->nama_lengkap }}</td>
                                    <td class="px-4 py-3 text-center">
                                        @if ($krs->status === 'draft')
                                            <form method="POST" action="{{ route('mahasiswa.krs.hapus', $detail) }}" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirmAction(event, 'Hapus Mata Kuliah', 'Hapus {{ $detail->kelasMatkul->mataKuliah->nama }} dari KRS?')"
                                                    class="px-3 py-1.5 bg-red-50 text-red-600 text-xs font-bold tracking-wide hover:bg-red-100 transition-colors duration-200">
                                                    Hapus
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-xs text-slate-400">-</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-12 text-center text-sm text-slate-400">
                                        Belum ada mata kuliah yang dipilih.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-white border border-slate-200 p-5">
                    <h3 class="text-sm font-bold text-slate-900 mb-3">Ringkasan</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-slate-500">Total SKS</span>
                            <span class="text-lg font-bold text-slate-900">{{ $krs->total_sks }} / {{ App\Models\Krs::MAX_SKS }}</span>
                        </div>
                        <div class="w-full bg-slate-100 h-2">
                            <div class="bg-slate-900 h-2 transition-all duration-500" style="width: {{ $krs->total_sks > 0 ? min(100, ($krs->total_sks / App\Models\Krs::MAX_SKS) * 100) : 0 }}%"></div>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-slate-500">Status</span>
                            <span class="text-xs font-semibold text-slate-700 uppercase">{{ $krs->status }}</span>
                        </div>
                    </div>

                    @if ($krs->status === 'draft' && $krs->details->count() > 0)
                        <form method="POST" action="{{ route('mahasiswa.krs.ajukan', $krs) }}" class="mt-4">
                            @csrf
                            @method('PATCH')
                            <button type="submit" onclick="return confirmAction(event, 'Ajukan KRS', 'Setelah diajukan, KRS tidak dapat diubah lagi. Lanjutkan?')"
                                class="w-full px-4 py-2.5 bg-slate-900 text-white text-xs font-bold tracking-wide hover:bg-slate-700 transition-colors duration-200">
                                Ajukan KRS
                            </button>
                        </form>
                    @endif

                    @if ($krs->status === 'ditolak')
                        <div class="mt-4 p-3 bg-red-50 border border-red-100">
                            <p class="text-xs font-semibold text-red-700">Catatan Penolakan:</p>
                            <p class="text-xs text-red-600 mt-1">{{ $krs->catatan ?? '-' }}</p>
                        </div>
                    @endif

                    @if ($krs->status === 'disetujui')
                        <div class="mt-4 p-3 bg-emerald-50 border border-emerald-100">
                            <p class="text-xs text-emerald-700">
                                Disetujui pada {{ $krs->disetujui_at?->format('d M Y H:i') ?? '-' }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
function confirmAction(event, title, description) {
    event.preventDefault();
    const form = event.target.closest('form');
    AppPopup.info({
        title: title,
        description: description,
        confirmText: 'Ya',
        cancelText: 'Batal',
        onConfirm: () => form.submit()
    });
    return false;
}
</script>
@endpush
