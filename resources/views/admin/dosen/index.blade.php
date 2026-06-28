@extends('dashboard.layouts.main')

@section('content')
<div class="animate-fade-in">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-lg font-bold text-slate-900">Manajemen Dosen</h1>
            <p class="text-sm text-slate-500">Kelola data dosen dalam sistem.</p>
        </div>
        <button onclick="openCreateModal()" class="inline-flex items-center gap-2 px-4 py-2.5 bg-slate-900 text-white text-xs font-bold tracking-wide hover:bg-slate-700 transition-colors duration-200">
            <i class="fa-solid fa-plus"></i>
            Tambah Dosen
        </button>
    </div>

    <div class="bg-white border border-slate-200">
        <div class="p-4 border-b border-slate-100">
            <form method="GET" action="{{ route('admin.dosen.index') }}">
                <div class="flex gap-3">
                    <div class="relative flex-1">
                        <i class="fa-solid fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari NIDN atau nama..." class="w-full pl-9 pr-4 py-2 border border-slate-200 text-sm focus:outline-none focus:border-slate-900 transition-colors duration-200">
                    </div>
                    <button type="submit" class="px-4 py-2 bg-slate-900 text-white text-xs font-bold tracking-wide hover:bg-slate-700 transition-colors duration-200">Cari</button>
                    @if(request('search'))
                        <a href="{{ route('admin.dosen.index') }}" class="px-4 py-2 border border-slate-200 text-slate-600 text-xs font-bold tracking-wide hover:bg-slate-50 transition-colors duration-200">Reset</a>
                    @endif
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100">
                        <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">NIDN</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Nama</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Gelar</th>
                        <th class="text-center px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">JK</th>
                        <th class="text-center px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($dosens as $dosen)
                    <tr class="hover:bg-slate-50 transition-colors duration-150"
                        data-edit-json="{{ json_encode([
                            'id' => $dosen->id,
                            'nidn' => $dosen->nidn,
                            'nama_lengkap' => $dosen->nama_lengkap,
                            'gelar_depan' => $dosen->gelar_depan,
                            'gelar_belakang' => $dosen->gelar_belakang,
                            'jenis_kelamin' => $dosen->jenis_kelamin,
                            'email' => $dosen->email,
                            'no_hp' => $dosen->no_hp,
                            'alamat' => $dosen->alamat,
                        ]) }}"
                        data-detail-json="{{ json_encode([
                            'nidn' => $dosen->nidn,
                            'nama_lengkap' => $dosen->nama_lengkap,
                            'gelar_depan' => $dosen->gelar_depan,
                            'gelar_belakang' => $dosen->gelar_belakang,
                            'jenis_kelamin' => $dosen->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan',
                            'email' => $dosen->email,
                            'no_hp' => $dosen->no_hp,
                            'alamat' => $dosen->alamat,
                            'created_at' => $dosen->created_at->format('d M Y H:i'),
                        ]) }}">
                        <td class="px-4 py-3 font-mono text-sm text-slate-900">{{ $dosen->nidn }}</td>
                        <td class="px-4 py-3 text-sm text-slate-700">{{ $dosen->nama_lengkap }}</td>
                        <td class="px-4 py-3 text-sm text-slate-500">{{ $dosen->gelar_depan }} {{ $dosen->gelar_belakang }}</td>
                        <td class="px-4 py-3 text-center text-sm text-slate-600">{{ $dosen->jenis_kelamin }}</td>
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-center gap-1">
                                <button onclick="openDetailModal({{ $dosen->id }})" class="w-8 h-8 flex items-center justify-center text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-all duration-200" title="Detail">
                                    <i class="fa-solid fa-eye text-sm"></i>
                                </button>
                                <button onclick="openEditModal(this)" class="w-8 h-8 flex items-center justify-center text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 transition-all duration-200" title="Edit">
                                    <i class="fa-solid fa-pen-to-square text-sm"></i>
                                </button>
                                <button onclick="confirmDelete({{ $dosen->id }}, '{{ $dosen->nama_lengkap }}')" class="w-8 h-8 flex items-center justify-center text-slate-400 hover:text-red-600 hover:bg-red-50 transition-all duration-200" title="Hapus">
                                    <i class="fa-solid fa-trash-can text-sm"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-12 text-center text-sm text-slate-400">
                            Tidak ada data dosen.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-4 py-3 border-t border-slate-100">
            {{ $dosens->withQueryString()->links() }}
        </div>
    </div>
</div>

<x-app-modal id="createModal" maxWidth="2xl" title="Tambah Dosen Baru" icon='<svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>' iconColor="indigo">
    <form id="createForm" method="POST" action="{{ route('admin.dosen.store') }}">
        @csrf
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="create_nidn">NIDN</label>
                <input id="create_nidn" type="text" name="nidn" placeholder="Masukkan NIDN" required>
            </div>
            <div>
                <label for="create_nama_lengkap">Nama Lengkap</label>
                <input id="create_nama_lengkap" type="text" name="nama_lengkap" placeholder="Masukkan nama" required>
            </div>
            <div>
                <label for="create_gelar_depan">Gelar Depan</label>
                <input id="create_gelar_depan" type="text" name="gelar_depan" placeholder="Contoh: Dr.">
            </div>
            <div>
                <label for="create_gelar_belakang">Gelar Belakang</label>
                <input id="create_gelar_belakang" type="text" name="gelar_belakang" placeholder="Contoh: S.Kom., M.Kom.">
            </div>
            <div>
                <label for="create_jenis_kelamin">Jenis Kelamin</label>
                <select id="create_jenis_kelamin" name="jenis_kelamin" required>
                    <option value="">Pilih</option>
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                </select>
            </div>
            <div>
                <label for="create_email">Email</label>
                <input id="create_email" type="email" name="email" placeholder="nama@contoh.com">
            </div>
            <div>
                <label for="create_no_hp">No. HP</label>
                <input id="create_no_hp" type="text" name="no_hp" placeholder="08xxxxxxxxxx">
            </div>
            <div class="col-span-2">
                <label for="create_alamat">Alamat</label>
                <textarea id="create_alamat" name="alamat" rows="2" placeholder="Masukkan alamat"></textarea>
            </div>
        </div>
    </form>
    <x-slot name="footer">
        <button type="button" onclick="AppModal.close('createModal')" class="modal-btn-cancel">Batal</button>
        <button type="submit" form="createForm" class="modal-btn-primary">Simpan</button>
    </x-slot>
</x-app-modal>

<x-app-modal id="editModal" maxWidth="2xl" title="Edit Dosen" icon='<svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>' iconColor="indigo">
    <form id="editForm" method="POST">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="edit_nidn">NIDN</label>
                <input id="edit_nidn" type="text" name="nidn" required>
            </div>
            <div>
                <label for="edit_nama_lengkap">Nama Lengkap</label>
                <input id="edit_nama_lengkap" type="text" name="nama_lengkap" required>
            </div>
            <div>
                <label for="edit_gelar_depan">Gelar Depan</label>
                <input id="edit_gelar_depan" type="text" name="gelar_depan">
            </div>
            <div>
                <label for="edit_gelar_belakang">Gelar Belakang</label>
                <input id="edit_gelar_belakang" type="text" name="gelar_belakang">
            </div>
            <div>
                <label for="edit_jenis_kelamin">Jenis Kelamin</label>
                <select id="edit_jenis_kelamin" name="jenis_kelamin" required>
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                </select>
            </div>
            <div>
                <label for="edit_email">Email</label>
                <input id="edit_email" type="email" name="email">
            </div>
            <div>
                <label for="edit_no_hp">No. HP</label>
                <input id="edit_no_hp" type="text" name="no_hp">
            </div>
            <div>
                <label for="edit_password">Kata Sandi <span class="text-slate-400 lowercase">(kosongkan jika tidak diubah)</span></label>
                <input id="edit_password" type="password" name="password" placeholder="Minimal 6 karakter">
            </div>
            <div class="col-span-2">
                <label for="edit_alamat">Alamat</label>
                <textarea id="edit_alamat" name="alamat" rows="2"></textarea>
            </div>
        </div>
    </form>
    <x-slot name="footer">
        <button type="button" onclick="AppModal.close('editModal')" class="modal-btn-cancel">Batal</button>
        <button type="submit" form="editForm" class="modal-btn-primary">Simpan</button>
    </x-slot>
</x-app-modal>

<x-app-modal id="detailModal" maxWidth="2xl" title="Detail Dosen" icon='<svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>' iconColor="indigo">
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

    document.getElementById('editForm').action = `/admin/dosen/${data.id}`;
    document.getElementById('edit_nidn').value = data.nidn;
    document.getElementById('edit_nama_lengkap').value = data.nama_lengkap;
    document.getElementById('edit_gelar_depan').value = data.gelar_depan || '';
    document.getElementById('edit_gelar_belakang').value = data.gelar_belakang || '';
    document.getElementById('edit_jenis_kelamin').value = data.jenis_kelamin;
    document.getElementById('edit_email').value = data.email || '';
    document.getElementById('edit_no_hp').value = data.no_hp || '';
    document.getElementById('edit_alamat').value = data.alamat || '';
    document.getElementById('edit_password').value = '';

    AppModal.open('editModal');
}

function openDetailModal(id) {
    const tr = document.querySelector(`button[onclick="openDetailModal(${id})"]`)?.closest('tr');
    const data = tr ? JSON.parse(tr.getAttribute('data-detail-json') || '{}') : {};

    document.getElementById('detailContent').innerHTML = `
        <div class="grid grid-cols-2 gap-4">
            <div><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">NIDN</p><p class="text-slate-900 font-mono mt-1">${data.nidn || '-'}</p></div>
            <div><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Nama Lengkap</p><p class="text-slate-900 mt-1">${data.nama_lengkap || '-'}</p></div>
            <div><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Gelar Depan</p><p class="text-slate-900 mt-1">${data.gelar_depan || '-'}</p></div>
            <div><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Gelar Belakang</p><p class="text-slate-900 mt-1">${data.gelar_belakang || '-'}</p></div>
            <div><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Jenis Kelamin</p><p class="text-slate-900 mt-1">${data.jenis_kelamin || '-'}</p></div>
            <div><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Email</p><p class="text-slate-900 mt-1">${data.email || '-'}</p></div>
            <div><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">No. HP</p><p class="text-slate-900 mt-1">${data.no_hp || '-'}</p></div>
            <div><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Dibuat Pada</p><p class="text-slate-900 mt-1">${data.created_at || '-'}</p></div>
            <div class="col-span-2"><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Alamat</p><p class="text-slate-900 mt-1">${data.alamat || '-'}</p></div>
        </div>
    `;
    AppModal.open('detailModal');
}

function confirmDelete(id, name) {
    AppPopup.confirm({
        title: 'Hapus Dosen',
        description: `Apakah Anda yakin ingin menghapus "${name}"? Semua data terkait akan ikut terhapus.`,
        confirmText: 'Ya, Hapus',
        cancelText: 'Batal',
        onConfirm: () => {
            document.getElementById('deleteForm').action = `/admin/dosen/${id}`;
            document.getElementById('deleteForm').submit();
        }
    });
}
</script>
@endpush
