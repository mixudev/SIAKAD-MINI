@extends('dashboard.layouts.main')

@section('content')
<div class="animate-fade-in">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-lg font-bold text-slate-900">Persetujuan KRS</h1>
            <p class="text-sm text-slate-500">Setujui atau tolak pengajuan KRS mahasiswa.</p>
        </div>
    </div>

    <div class="bg-white border border-slate-200">
        <div class="px-4 py-3 border-b border-slate-100">
            <form method="GET" action="{{ route('admin.krs.index') }}">
                <div class="flex gap-3">
                    <select name="semester_id" onchange="this.form.submit()" class="px-3 py-2 border border-slate-200 text-sm focus:outline-none focus:border-slate-900">
                        @foreach($semesters as $s)
                            <option value="{{ $s->id }}" {{ $s->id == $semesterId ? 'selected' : '' }}>
                                {{ $s->nama }}
                            </option>
                        @endforeach
                    </select>
                    <select name="status" onchange="this.form.submit()" class="px-3 py-2 border border-slate-200 text-sm focus:outline-none focus:border-slate-900">
                        <option value="">Semua Status</option>
                        <option value="diajukan" {{ request('status') === 'diajukan' ? 'selected' : '' }}>Diajukan</option>
                        <option value="disetujui" {{ request('status') === 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                        <option value="ditolak" {{ request('status') === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                        <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                    </select>
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100">
                        <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">NIM</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Mahasiswa</th>
                        <th class="text-center px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">SKS</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Semester</th>
                        <th class="text-center px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="text-center px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Diajukan</th>
                        <th class="text-center px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($daftarKrs as $krs)
                    <tr class="hover:bg-slate-50 transition-colors duration-150"
                        data-detail-json="{{ json_encode([
                            'nim' => $krs->mahasiswa->user->identifier,
                            'nama' => $krs->mahasiswa->nama_lengkap,
                            'prodi' => $krs->mahasiswa->program_studi,
                            'semester' => $krs->semester->nama,
                            'total_sks' => $krs->total_sks,
                            'status' => $krs->status,
                            'matkuls' => $krs->details->map(fn($d) => [
                                'kode' => $d->kelasMatkul->mataKuliah->kode,
                                'nama' => $d->kelasMatkul->mataKuliah->nama,
                                'sks' => $d->sks_diambil,
                                'kelas' => $d->kelasMatkul->nama_kelas,
                                'dosen' => $d->kelasMatkul->dosen->nama_lengkap,
                            ])->toArray(),
                            'diajukan_at' => $krs->diajukan_at?->format('d M Y H:i'),
                            'disetujui_at' => $krs->disetujui_at?->format('d M Y H:i'),
                            'catatan' => $krs->catatan,
                        ]) }}">
                        <td class="px-4 py-3 font-mono text-sm text-slate-900">{{ $krs->mahasiswa->user->identifier }}</td>
                        <td class="px-4 py-3 text-sm text-slate-700">{{ $krs->mahasiswa->nama_lengkap }}</td>
                        <td class="px-4 py-3 text-center text-sm font-semibold text-slate-900">{{ $krs->total_sks }}</td>
                        <td class="px-4 py-3 text-sm text-slate-600">{{ $krs->semester->nama }}</td>
                        <td class="px-4 py-3 text-center">
                            @php
                                $statusClass = match($krs->status) {
                                    'draft' => 'text-amber-600 bg-amber-50',
                                    'diajukan' => 'text-blue-600 bg-blue-50',
                                    'disetujui' => 'text-emerald-600 bg-emerald-50',
                                    'ditolak' => 'text-red-600 bg-red-50',
                                    default => 'text-slate-600 bg-slate-50',
                                };
                            @endphp
                            <span class="inline-block px-2 py-0.5 text-xs font-semibold uppercase {{ $statusClass }}">{{ $krs->status }}</span>
                        </td>
                        <td class="px-4 py-3 text-center text-sm text-slate-600">{{ $krs->diajukan_at?->format('d M Y H:i') ?? '-' }}</td>
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-center gap-1">
                                <button onclick="openDetailModal({{ $krs->id }})" class="w-8 h-8 flex items-center justify-center text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-all duration-200" title="Detail">
                                    <i class="fa-solid fa-eye text-sm"></i>
                                </button>
                                @if ($krs->status === 'diajukan')
                                <form method="POST" action="{{ route('admin.krs.approve', $krs) }}" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" onclick="return confirmAction(event, 'Setujui KRS', 'Setujui KRS {{ $krs->mahasiswa->nama_lengkap }} ({{ $krs->mahasiswa->user->identifier }})?')"
                                        class="px-3 py-1.5 bg-emerald-50 text-emerald-600 text-xs font-bold tracking-wide hover:bg-emerald-100 transition-colors duration-200">
                                        Setuju
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.krs.tolak', $krs) }}" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" onclick="return confirmTolak(event, this)"
                                        class="px-3 py-1.5 bg-red-50 text-red-600 text-xs font-bold tracking-wide hover:bg-red-100 transition-colors duration-200">
                                        Tolak
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-12 text-center text-sm text-slate-400">
                            Tidak ada data KRS.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<x-app-modal id="detailModal" maxWidth="2xl" title="Detail KRS" icon='<svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>' iconColor="indigo">
    <div id="detailContent" class="space-y-3 text-sm text-slate-600">
        <p class="text-slate-400">Memuat data...</p>
    </div>
    <x-slot name="footer">
        <button type="button" onclick="AppModal.close('detailModal')" class="modal-btn-cancel">Tutup</button>
    </x-slot>
</x-app-modal>
@endsection

@push('scripts')
<script>
function confirmAction(event, title, description) {
    event.preventDefault();
    const form = event.target.closest('form');
    AppPopup.confirm({
        title: title,
        description: description,
        confirmText: 'Ya',
        cancelText: 'Batal',
        onConfirm: () => form.submit()
    });
    return false;
}

function confirmTolak(event, btn) {
    event.preventDefault();
    const form = btn.closest('form');
    AppPopup.prompt({
        title: 'Tolak KRS',
        description: 'Berikan alasan penolakan (opsional):',
        confirmText: 'Tolak',
        cancelText: 'Batal',
        onConfirm: (value) => {
            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'catatan';
            input.value = value;
            form.appendChild(input);
            form.submit();
        }
    });
    return false;
}

function openDetailModal(id) {
    const tr = document.querySelector(`button[onclick="openDetailModal(${id})"]`)?.closest('tr');
    const data = tr ? JSON.parse(tr.getAttribute('data-detail-json') || '{}') : {};

    let matkulHtml = '';
    if (data.matkuls && data.matkuls.length > 0) {
        matkulHtml = `<div class="col-span-2"><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Mata Kuliah</p>
            <table class="w-full text-xs border border-slate-100">
                <thead><tr class="bg-slate-50"><th class="text-left px-2 py-1 font-semibold text-slate-500">Kode</th><th class="text-left px-2 py-1 font-semibold text-slate-500">Nama</th><th class="text-center px-2 py-1 font-semibold text-slate-500">SKS</th><th class="text-left px-2 py-1 font-semibold text-slate-500">Kelas</th><th class="text-left px-2 py-1 font-semibold text-slate-500">Dosen</th></tr></thead>
                <tbody>`;
        data.matkuls.forEach(m => {
            matkulHtml += `<tr class="border-t border-slate-50"><td class="px-2 py-1 font-mono">${m.kode}</td><td class="px-2 py-1">${m.nama}</td><td class="px-2 py-1 text-center">${m.sks}</td><td class="px-2 py-1">${m.kelas}</td><td class="px-2 py-1">${m.dosen}</td></tr>`;
        });
        matkulHtml += `</tbody></table></div>`;
    }

    document.getElementById('detailContent').innerHTML = `
        <div class="grid grid-cols-2 gap-4">
            <div><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">NIM</p><p class="text-slate-900 font-mono mt-1">${data.nim || '-'}</p></div>
            <div><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Nama</p><p class="text-slate-900 mt-1">${data.nama || '-'}</p></div>
            <div><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Program Studi</p><p class="text-slate-900 mt-1">${data.prodi || '-'}</p></div>
            <div><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Semester</p><p class="text-slate-900 mt-1">${data.semester || '-'}</p></div>
            <div><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total SKS</p><p class="text-slate-900 mt-1 font-bold">${data.total_sks || '0'}</p></div>
            <div><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Status</p><p class="mt-1"><span class="inline-block px-2 py-0.5 text-xs font-semibold uppercase ${data.status === 'disetujui' ? 'text-emerald-600 bg-emerald-50' : data.status === 'ditolak' ? 'text-red-600 bg-red-50' : data.status === 'diajukan' ? 'text-blue-600 bg-blue-50' : 'text-amber-600 bg-amber-50'}">${data.status || '-'}</span></p></div>
            ${matkulHtml}
            <div><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Diajukan Pada</p><p class="text-slate-900 mt-1">${data.diajukan_at || '-'}</p></div>
            <div><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Disetujui Pada</p><p class="text-slate-900 mt-1">${data.disetujui_at || '-'}</p></div>
            ${data.catatan ? `<div class="col-span-2"><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Catatan</p><p class="text-slate-900 mt-1">${data.catatan}</p></div>` : ''}
        </div>
    `;
    AppModal.open('detailModal');
}
</script>
@endpush
