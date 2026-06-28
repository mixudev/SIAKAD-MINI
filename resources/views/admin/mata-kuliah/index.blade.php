@extends('dashboard.layouts.main')

@section('content')
<div class="animate-fade-in">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-lg font-bold text-slate-900">Manajemen Mata Kuliah</h1>
            <p class="text-sm text-slate-500">Kelola data mata kuliah dalam sistem.</p>
        </div>
        <button onclick="openCreateModal()" class="inline-flex items-center gap-2 px-4 py-2.5 bg-slate-900 text-white text-xs font-bold tracking-wide hover:bg-slate-700 transition-colors duration-200">
            <i class="fa-solid fa-plus"></i>
            Tambah Mata Kuliah
        </button>
    </div>

    <div class="bg-white border border-slate-200">
        <div class="p-4 border-b border-slate-100">
            <form method="GET" action="{{ route('admin.mata-kuliah.index') }}">
                <div class="flex gap-3">
                    <div class="relative flex-1">
                        <i class="fa-solid fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kode atau nama..." class="w-full pl-9 pr-4 py-2 border border-slate-200 text-sm focus:outline-none focus:border-slate-900 transition-colors duration-200">
                    </div>
                    <button type="submit" class="px-4 py-2 bg-slate-900 text-white text-xs font-bold tracking-wide hover:bg-slate-700 transition-colors duration-200">Cari</button>
                    @if(request('search'))
                        <a href="{{ route('admin.mata-kuliah.index') }}" class="px-4 py-2 border border-slate-200 text-slate-600 text-xs font-bold tracking-wide hover:bg-slate-50 transition-colors duration-200">Reset</a>
                    @endif
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100">
                        <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Kode</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Nama</th>
                        <th class="text-center px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">SKS</th>
                        <th class="text-center px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Semester Ke</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Prodi</th>
                        <th class="text-center px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="text-center px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($mataKuliahs as $mk)
                    <tr class="hover:bg-slate-50 transition-colors duration-150"
                        data-edit-json="{{ json_encode([
                            'id' => $mk->id,
                            'kode' => $mk->kode,
                            'nama' => $mk->nama,
                            'sks' => $mk->sks,
                            'semester_ke' => $mk->semester_ke,
                            'program_studi' => $mk->program_studi,
                            'deskripsi' => $mk->deskripsi,
                            'is_active' => $mk->is_active,
                        ]) }}"
                        data-detail-json="{{ json_encode([
                            'kode' => $mk->kode,
                            'nama' => $mk->nama,
                            'sks' => $mk->sks,
                            'semester_ke' => $mk->semester_ke,
                            'program_studi' => $mk->program_studi,
                            'deskripsi' => $mk->deskripsi,
                            'is_active' => $mk->is_active,
                            'created_at' => $mk->created_at->format('d M Y H:i'),
                        ]) }}">
                        <td class="px-4 py-3 font-mono text-sm text-slate-900">{{ $mk->kode }}</td>
                        <td class="px-4 py-3 text-sm text-slate-700">{{ $mk->nama }}</td>
                        <td class="px-4 py-3 text-center text-sm font-semibold text-slate-900">{{ $mk->sks }}</td>
                        <td class="px-4 py-3 text-center text-sm text-slate-600">{{ $mk->semester_ke }}</td>
                        <td class="px-4 py-3 text-sm text-slate-600">{{ $mk->program_studi }}</td>
                        <td class="px-4 py-3 text-center">
                            @if($mk->is_active)
                                <span class="inline-flex items-center gap-1 text-xs font-semibold text-emerald-600">
                                    <span class="w-1.5 h-1.5 bg-emerald-500"></span>
                                    Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 text-xs font-semibold text-slate-400">
                                    <span class="w-1.5 h-1.5 bg-slate-300"></span>
                                    Tidak Aktif
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-center gap-1">
                                <button onclick="openDetailModal({{ $mk->id }})" class="w-8 h-8 flex items-center justify-center text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-all duration-200" title="Detail">
                                    <i class="fa-solid fa-eye text-sm"></i>
                                </button>
                                <button onclick="openEditModal(this)" class="w-8 h-8 flex items-center justify-center text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 transition-all duration-200" title="Edit">
                                    <i class="fa-solid fa-pen-to-square text-sm"></i>
                                </button>
                                <button onclick="confirmDelete({{ $mk->id }}, '{{ $mk->nama }}')" class="w-8 h-8 flex items-center justify-center text-slate-400 hover:text-red-600 hover:bg-red-50 transition-all duration-200" title="Hapus">
                                    <i class="fa-solid fa-trash-can text-sm"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-12 text-center text-sm text-slate-400">
                            Tidak ada data mata kuliah.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-4 py-3 border-t border-slate-100">
            {{ $mataKuliahs->withQueryString()->links() }}
        </div>
    </div>
</div>

<x-app-modal id="createModal" maxWidth="2xl" title="Tambah Mata Kuliah Baru" icon='<svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 016.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"/></svg>' iconColor="indigo">
    <form id="createForm" method="POST" action="{{ route('admin.mata-kuliah.store') }}">
        @csrf
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="create_kode">Kode MK</label>
                <input id="create_kode" type="text" name="kode" placeholder="Contoh: SI101" required>
            </div>
            <div>
                <label for="create_nama">Nama Mata Kuliah</label>
                <input id="create_nama" type="text" name="nama" placeholder="Masukkan nama matkul" required>
            </div>
            <div>
                <label for="create_sks">SKS</label>
                <input id="create_sks" type="number" name="sks" placeholder="Contoh: 3" min="1" max="24" required>
            </div>
            <div>
                <label for="create_semester_ke">Semester Ke</label>
                <input id="create_semester_ke" type="number" name="semester_ke" placeholder="Contoh: 1" min="1" max="14" required>
            </div>
            <div>
                <label for="create_program_studi">Program Studi</label>
                <input id="create_program_studi" type="text" name="program_studi" placeholder="Contoh: Sistem Informasi" required>
            </div>
            <div>
                <label for="create_is_active">Status</label>
                <select id="create_is_active" name="is_active">
                    <option value="1">Aktif</option>
                    <option value="0">Tidak Aktif</option>
                </select>
            </div>
            <div class="col-span-2">
                <label for="create_deskripsi">Deskripsi</label>
                <textarea id="create_deskripsi" name="deskripsi" rows="3" placeholder="Masukkan deskripsi mata kuliah (opsional)"></textarea>
            </div>
        </div>
    </form>
    <x-slot name="footer">
        <button type="button" onclick="AppModal.close('createModal')" class="modal-btn-cancel">Batal</button>
        <button type="submit" form="createForm" class="modal-btn-primary">Simpan</button>
    </x-slot>
</x-app-modal>

<x-app-modal id="editModal" maxWidth="2xl" title="Edit Mata Kuliah" icon='<svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>' iconColor="indigo">
    <form id="editForm" method="POST">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="edit_kode">Kode MK</label>
                <input id="edit_kode" type="text" name="kode" required>
            </div>
            <div>
                <label for="edit_nama">Nama Mata Kuliah</label>
                <input id="edit_nama" type="text" name="nama" required>
            </div>
            <div>
                <label for="edit_sks">SKS</label>
                <input id="edit_sks" type="number" name="sks" min="1" max="24" required>
            </div>
            <div>
                <label for="edit_semester_ke">Semester Ke</label>
                <input id="edit_semester_ke" type="number" name="semester_ke" min="1" max="14" required>
            </div>
            <div>
                <label for="edit_program_studi">Program Studi</label>
                <input id="edit_program_studi" type="text" name="program_studi" required>
            </div>
            <div>
                <label for="edit_is_active">Status</label>
                <select id="edit_is_active" name="is_active">
                    <option value="1">Aktif</option>
                    <option value="0">Tidak Aktif</option>
                </select>
            </div>
            <div class="col-span-2">
                <label for="edit_deskripsi">Deskripsi</label>
                <textarea id="edit_deskripsi" name="deskripsi" rows="3"></textarea>
            </div>
        </div>
    </form>
    <x-slot name="footer">
        <button type="button" onclick="AppModal.close('editModal')" class="modal-btn-cancel">Batal</button>
        <button type="submit" form="editForm" class="modal-btn-primary">Simpan</button>
    </x-slot>
</x-app-modal>

<x-app-modal id="detailModal" maxWidth="2xl" title="Detail Mata Kuliah" icon='<svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 016.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"/></svg>' iconColor="indigo">
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

    document.getElementById('editForm').action = `/admin/mata-kuliah/${data.id}`;
    document.getElementById('edit_kode').value = data.kode;
    document.getElementById('edit_nama').value = data.nama;
    document.getElementById('edit_sks').value = data.sks;
    document.getElementById('edit_semester_ke').value = data.semester_ke;
    document.getElementById('edit_program_studi').value = data.program_studi;
    document.getElementById('edit_is_active').value = data.is_active ? '1' : '0';
    document.getElementById('edit_deskripsi').value = data.deskripsi || '';

    AppModal.open('editModal');
}

function openDetailModal(id) {
    const tr = document.querySelector(`button[onclick="openDetailModal(${id})"]`)?.closest('tr');
    const data = tr ? JSON.parse(tr.getAttribute('data-detail-json') || '{}') : {};

    document.getElementById('detailContent').innerHTML = `
        <div class="grid grid-cols-2 gap-4">
            <div><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Kode MK</p><p class="text-slate-900 font-mono mt-1">${data.kode || '-'}</p></div>
            <div><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Nama Mata Kuliah</p><p class="text-slate-900 mt-1">${data.nama || '-'}</p></div>
            <div><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">SKS</p><p class="text-slate-900 mt-1 font-semibold">${data.sks || '-'}</p></div>
            <div><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Semester Ke</p><p class="text-slate-900 mt-1">${data.semester_ke || '-'}</p></div>
            <div><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Program Studi</p><p class="text-slate-900 mt-1">${data.program_studi || '-'}</p></div>
            <div><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Status</p><p class="mt-1"><span class="font-semibold text-xs ${data.is_active ? 'text-emerald-600' : 'text-slate-400'}">${data.is_active ? 'Aktif' : 'Tidak Aktif'}</span></p></div>
            <div class="col-span-2"><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Deskripsi</p><p class="text-slate-900 mt-1">${data.deskripsi || '-'}</p></div>
            <div><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Dibuat Pada</p><p class="text-slate-900 mt-1">${data.created_at || '-'}</p></div>
        </div>
    `;
    AppModal.open('detailModal');
}

function confirmDelete(id, name) {
    AppPopup.confirm({
        title: 'Hapus Mata Kuliah',
        description: `Apakah Anda yakin ingin menghapus "${name}"?`,
        confirmText: 'Ya, Hapus',
        cancelText: 'Batal',
        onConfirm: () => {
            document.getElementById('deleteForm').action = `/admin/mata-kuliah/${id}`;
            document.getElementById('deleteForm').submit();
        }
    });
}
</script>
@endpush
