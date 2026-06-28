@extends('dashboard.layouts.main')

@section('content')
<div class="animate-fade-in">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-lg font-bold text-slate-900">Manajemen Semester</h1>
            <p class="text-sm text-slate-500">Kelola data semester dalam sistem.</p>
        </div>
        <button onclick="openCreateModal()" class="inline-flex items-center gap-2 px-4 py-2.5 bg-slate-900 text-white text-xs font-bold tracking-wide hover:bg-slate-700 transition-colors duration-200">
            <i class="fa-solid fa-plus"></i>
            Tambah Semester
        </button>
    </div>

    <div class="bg-white border border-slate-200">
        <div class="p-4 border-b border-slate-100">
            <form method="GET" action="{{ route('admin.semester.index') }}">
                <div class="flex gap-3">
                    <div class="relative flex-1">
                        <i class="fa-solid fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau tahun ajaran..." class="w-full pl-9 pr-4 py-2 border border-slate-200 text-sm focus:outline-none focus:border-slate-900 transition-colors duration-200">
                    </div>
                    <button type="submit" class="px-4 py-2 bg-slate-900 text-white text-xs font-bold tracking-wide hover:bg-slate-700 transition-colors duration-200">Cari</button>
                    @if(request('search'))
                        <a href="{{ route('admin.semester.index') }}" class="px-4 py-2 border border-slate-200 text-slate-600 text-xs font-bold tracking-wide hover:bg-slate-50 transition-colors duration-200">Reset</a>
                    @endif
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100">
                        <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Nama</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Tahun Ajaran</th>
                        <th class="text-center px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Tipe</th>
                        <th class="text-center px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Aktif</th>
                        <th class="text-center px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($semesters as $semester)
                    <tr class="hover:bg-slate-50 transition-colors duration-150"
                        data-edit-json="{{ json_encode([
                            'id' => $semester->id,
                            'nama' => $semester->nama,
                            'tahun_ajaran' => $semester->tahun_ajaran,
                            'tipe' => $semester->tipe,
                            'tanggal_mulai' => $semester->tanggal_mulai->format('Y-m-d'),
                            'tanggal_selesai' => $semester->tanggal_selesai->format('Y-m-d'),
                            'krs_mulai' => $semester->krs_mulai?->format('Y-m-d'),
                            'krs_selesai' => $semester->krs_selesai?->format('Y-m-d'),
                            'is_active' => $semester->is_active,
                        ]) }}"
                        data-detail-json="{{ json_encode([
                            'nama' => $semester->nama,
                            'tahun_ajaran' => $semester->tahun_ajaran,
                            'tipe' => $semester->tipe,
                            'tanggal_mulai' => $semester->tanggal_mulai->format('d M Y'),
                            'tanggal_selesai' => $semester->tanggal_selesai->format('d M Y'),
                            'krs_mulai' => $semester->krs_mulai?->format('d M Y'),
                            'krs_selesai' => $semester->krs_selesai?->format('d M Y'),
                            'is_active' => $semester->is_active,
                            'created_at' => $semester->created_at->format('d M Y H:i'),
                        ]) }}">
                        <td class="px-4 py-3 text-sm text-slate-700">{{ $semester->nama }}</td>
                        <td class="px-4 py-3 text-sm text-slate-600">{{ $semester->tahun_ajaran }}</td>
                        <td class="px-4 py-3 text-center">
                            @php
                                $tipeClass = $semester->tipe === 'ganjil' ? 'bg-purple-100 text-purple-700' : 'bg-orange-100 text-orange-700';
                            @endphp
                            <span class="inline-block px-2 py-0.5 text-xs font-semibold uppercase {{ $tipeClass }}">{{ $semester->tipe }}</span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            @if($semester->is_active)
                                <span class="inline-flex items-center gap-1 text-xs font-semibold text-emerald-600">
                                    <span class="w-1.5 h-1.5 bg-emerald-500"></span>
                                    Aktif
                                </span>
                            @else
                                <form method="POST" action="{{ route('admin.semester.set-active', $semester->id) }}" class="inline" id="setActiveForm-{{ $semester->id }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="button" onclick="confirmSetActive({{ $semester->id }}, '{{ $semester->nama }}')" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 underline">Aktifkan</button>
                                </form>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-center gap-1">
                                <button onclick="openDetailModal({{ $semester->id }})" class="w-8 h-8 flex items-center justify-center text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-all duration-200" title="Detail">
                                    <i class="fa-solid fa-eye text-sm"></i>
                                </button>
                                <button onclick="openEditModal(this)" class="w-8 h-8 flex items-center justify-center text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 transition-all duration-200" title="Edit">
                                    <i class="fa-solid fa-pen-to-square text-sm"></i>
                                </button>
                                @if(!$semester->is_active)
                                <button onclick="confirmDelete({{ $semester->id }}, '{{ $semester->nama }}')" class="w-8 h-8 flex items-center justify-center text-slate-400 hover:text-red-600 hover:bg-red-50 transition-all duration-200" title="Hapus">
                                    <i class="fa-solid fa-trash-can text-sm"></i>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-12 text-center text-sm text-slate-400">
                            Tidak ada data semester.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-4 py-3 border-t border-slate-100">
            {{ $semesters->withQueryString()->links() }}
        </div>
    </div>
</div>

<x-app-modal id="createModal" maxWidth="2xl" title="Tambah Semester Baru" icon='<svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>' iconColor="indigo">
    <form id="createForm" method="POST" action="{{ route('admin.semester.store') }}">
        @csrf
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="create_nama">Nama Semester</label>
                <input id="create_nama" type="text" name="nama" placeholder="Contoh: Semester Ganjil 2024/2025" required>
            </div>
            <div>
                <label for="create_tahun_ajaran">Tahun Ajaran</label>
                <input id="create_tahun_ajaran" type="text" name="tahun_ajaran" placeholder="Contoh: 2024/2025" required>
            </div>
            <div>
                <label for="create_tipe">Tipe</label>
                <select id="create_tipe" name="tipe" required>
                    <option value="">Pilih</option>
                    <option value="ganjil">Ganjil</option>
                    <option value="genap">Genap</option>
                </select>
            </div>
            <div>
                <label for="create_is_active">Status Aktif</label>
                <select id="create_is_active" name="is_active">
                    <option value="0">Tidak</option>
                    <option value="1">Ya</option>
                </select>
            </div>
            <div>
                <label for="create_tanggal_mulai">Tanggal Mulai</label>
                <input id="create_tanggal_mulai" type="date" name="tanggal_mulai" required>
            </div>
            <div>
                <label for="create_tanggal_selesai">Tanggal Selesai</label>
                <input id="create_tanggal_selesai" type="date" name="tanggal_selesai" required>
            </div>
            <div>
                <label for="create_krs_mulai">KRS Mulai</label>
                <input id="create_krs_mulai" type="date" name="krs_mulai">
            </div>
            <div>
                <label for="create_krs_selesai">KRS Selesai</label>
                <input id="create_krs_selesai" type="date" name="krs_selesai">
            </div>
        </div>
    </form>
    <x-slot name="footer">
        <button type="button" onclick="AppModal.close('createModal')" class="modal-btn-cancel">Batal</button>
        <button type="submit" form="createForm" class="modal-btn-primary">Simpan</button>
    </x-slot>
</x-app-modal>

<x-app-modal id="editModal" maxWidth="2xl" title="Edit Semester" icon='<svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>' iconColor="indigo">
    <form id="editForm" method="POST">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="edit_nama">Nama Semester</label>
                <input id="edit_nama" type="text" name="nama" required>
            </div>
            <div>
                <label for="edit_tahun_ajaran">Tahun Ajaran</label>
                <input id="edit_tahun_ajaran" type="text" name="tahun_ajaran" required>
            </div>
            <div>
                <label for="edit_tipe">Tipe</label>
                <select id="edit_tipe" name="tipe" required>
                    <option value="ganjil">Ganjil</option>
                    <option value="genap">Genap</option>
                </select>
            </div>
            <div>
                <label for="edit_is_active">Status Aktif</label>
                <select id="edit_is_active" name="is_active">
                    <option value="0">Tidak</option>
                    <option value="1">Ya</option>
                </select>
            </div>
            <div>
                <label for="edit_tanggal_mulai">Tanggal Mulai</label>
                <input id="edit_tanggal_mulai" type="date" name="tanggal_mulai" required>
            </div>
            <div>
                <label for="edit_tanggal_selesai">Tanggal Selesai</label>
                <input id="edit_tanggal_selesai" type="date" name="tanggal_selesai" required>
            </div>
            <div>
                <label for="edit_krs_mulai">KRS Mulai</label>
                <input id="edit_krs_mulai" type="date" name="krs_mulai">
            </div>
            <div>
                <label for="edit_krs_selesai">KRS Selesai</label>
                <input id="edit_krs_selesai" type="date" name="krs_selesai">
            </div>
        </div>
    </form>
    <x-slot name="footer">
        <button type="button" onclick="AppModal.close('editModal')" class="modal-btn-cancel">Batal</button>
        <button type="submit" form="editForm" class="modal-btn-primary">Simpan</button>
    </x-slot>
</x-app-modal>

<x-app-modal id="detailModal" maxWidth="2xl" title="Detail Semester" icon='<svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>' iconColor="indigo">
    <div id="detailContent" class="space-y-3 text-sm text-slate-600">
        <p class="text-slate-400">Memuat data...</p>
    </div>
    <x-slot name="footer">
        <button type="button" onclick="AppModal.close('detailModal')" class="modal-btn-cancel">Tutup</button>
    </x-slot>
</x-app-modal>

<form id="deleteForm" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>
@endsection

@push('scripts')
<script>
function openCreateModal() {
    document.getElementById('createForm').reset();
    AppModal.open('createModal');
}

function openEditModal(btn) {
    const tr = btn.closest('tr');
    const data = JSON.parse(tr.getAttribute('data-edit-json') || '{}');

    document.getElementById('editForm').action = `/admin/semester/${data.id}`;
    document.getElementById('edit_nama').value = data.nama;
    document.getElementById('edit_tahun_ajaran').value = data.tahun_ajaran;
    document.getElementById('edit_tipe').value = data.tipe;
    document.getElementById('edit_is_active').value = data.is_active ? '1' : '0';
    document.getElementById('edit_tanggal_mulai').value = data.tanggal_mulai;
    document.getElementById('edit_tanggal_selesai').value = data.tanggal_selesai;
    document.getElementById('edit_krs_mulai').value = data.krs_mulai || '';
    document.getElementById('edit_krs_selesai').value = data.krs_selesai || '';

    AppModal.open('editModal');
}

function openDetailModal(id) {
    const tr = document.querySelector(`button[onclick="openDetailModal(${id})"]`)?.closest('tr');
    const data = tr ? JSON.parse(tr.getAttribute('data-detail-json') || '{}') : {};

    document.getElementById('detailContent').innerHTML = `
        <div class="grid grid-cols-2 gap-4">
            <div><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Nama</p><p class="text-slate-900 mt-1">${data.nama || '-'}</p></div>
            <div><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Tahun Ajaran</p><p class="text-slate-900 mt-1">${data.tahun_ajaran || '-'}</p></div>
            <div><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Tipe</p><p class="text-slate-900 mt-1 font-semibold uppercase">${data.tipe || '-'}</p></div>
            <div><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Status</p><p class="mt-1"><span class="font-semibold text-xs ${data.is_active ? 'text-emerald-600' : 'text-slate-400'}">${data.is_active ? 'Aktif' : 'Tidak Aktif'}</span></p></div>
            <div><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Tanggal Mulai</p><p class="text-slate-900 mt-1">${data.tanggal_mulai || '-'}</p></div>
            <div><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Tanggal Selesai</p><p class="text-slate-900 mt-1">${data.tanggal_selesai || '-'}</p></div>
            <div><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">KRS Mulai</p><p class="text-slate-900 mt-1">${data.krs_mulai || '-'}</p></div>
            <div><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">KRS Selesai</p><p class="text-slate-900 mt-1">${data.krs_selesai || '-'}</p></div>
            <div><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Dibuat Pada</p><p class="text-slate-900 mt-1">${data.created_at || '-'}</p></div>
        </div>
    `;
    AppModal.open('detailModal');
}

function confirmSetActive(id, name) {
    AppPopup.confirm({
        title: 'Aktifkan Semester',
        description: `Apakah Anda yakin ingin mengaktifkan "${name}"? Semester yang sebelumnya aktif akan dinonaktifkan.`,
        confirmText: 'Ya, Aktifkan',
        cancelText: 'Batal',
        onConfirm: () => {
            document.getElementById(`setActiveForm-${id}`).submit();
        }
    });
}

function confirmDelete(id, name) {
    AppPopup.confirm({
        title: 'Hapus Semester',
        description: `Apakah Anda yakin ingin menghapus "${name}"?`,
        confirmText: 'Ya, Hapus',
        cancelText: 'Batal',
        onConfirm: () => {
            document.getElementById('deleteForm').action = `/admin/semester/${id}`;
            document.getElementById('deleteForm').submit();
        }
    });
}
</script>
@endpush
