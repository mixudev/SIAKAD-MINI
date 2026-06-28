@extends('dashboard.layouts.main')

@section('content')
<div class="animate-fade-in">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-lg font-bold text-slate-900">Manajemen Mahasiswa</h1>
            <p class="text-sm text-slate-500">Kelola data mahasiswa dalam sistem.</p>
        </div>
        <button onclick="openCreateModal()" class="inline-flex items-center gap-2 px-4 py-2.5 bg-slate-900 text-white text-xs font-bold tracking-wide hover:bg-slate-700 transition-colors duration-200">
            <i class="fa-solid fa-plus"></i>
            Tambah Mahasiswa
        </button>
    </div>

    <div class="bg-white border border-slate-200">
        <div class="p-4 border-b border-slate-100">
            <form method="GET" action="{{ route('admin.mahasiswa.index') }}">
                <div class="flex gap-3">
                    <div class="relative flex-1">
                        <i class="fa-solid fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari NIM atau nama..." class="w-full pl-9 pr-4 py-2 border border-slate-200 text-sm focus:outline-none focus:border-slate-900 transition-colors duration-200">
                    </div>
                    <button type="submit" class="px-4 py-2 bg-slate-900 text-white text-xs font-bold tracking-wide hover:bg-slate-700 transition-colors duration-200">Cari</button>
                    @if(request('search'))
                        <a href="{{ route('admin.mahasiswa.index') }}" class="px-4 py-2 border border-slate-200 text-slate-600 text-xs font-bold tracking-wide hover:bg-slate-50 transition-colors duration-200">Reset</a>
                    @endif
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100">
                        <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">NIM</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Nama</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Prodi</th>
                        <th class="text-center px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Angkatan</th>
                        <th class="text-center px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="text-center px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($mahasiswas as $mhs)
                    <tr class="hover:bg-slate-50 transition-colors duration-150"
                        data-edit-json="{{ json_encode([
                            'id' => $mhs->id,
                            'nim' => $mhs->nim,
                            'nama_lengkap' => $mhs->nama_lengkap,
                            'angkatan' => $mhs->angkatan,
                            'program_studi' => $mhs->program_studi,
                            'jenis_kelamin' => $mhs->jenis_kelamin,
                            'status' => $mhs->status,
                            'email' => $mhs->email,
                            'no_hp' => $mhs->no_hp,
                            'alamat' => $mhs->alamat,
                        ]) }}"
                        data-detail-json="{{ json_encode([
                            'nim' => $mhs->nim,
                            'nama_lengkap' => $mhs->nama_lengkap,
                            'program_studi' => $mhs->program_studi,
                            'angkatan' => $mhs->angkatan,
                            'jenis_kelamin' => $mhs->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan',
                            'status' => $mhs->status,
                            'email' => $mhs->email,
                            'no_hp' => $mhs->no_hp,
                            'alamat' => $mhs->alamat,
                            'created_at' => $mhs->created_at->format('d M Y H:i'),
                            'identifier' => $mhs->user?->identifier ?? '-',
                        ]) }}">
                        <td class="px-4 py-3 font-mono text-sm text-slate-900">{{ $mhs->nim }}</td>
                        <td class="px-4 py-3 text-sm text-slate-700">{{ $mhs->nama_lengkap }}</td>
                        <td class="px-4 py-3 text-sm text-slate-600">{{ $mhs->program_studi }}</td>
                        <td class="px-4 py-3 text-center text-sm text-slate-600">{{ $mhs->angkatan }}</td>
                        <td class="px-4 py-3 text-center">
                            @php
                                $statusClass = match($mhs->status) {
                                    'aktif' => 'text-emerald-600 bg-emerald-50',
                                    'cuti' => 'text-amber-600 bg-amber-50',
                                    'lulus' => 'text-blue-600 bg-blue-50',
                                    'dropout' => 'text-red-600 bg-red-50',
                                    default => 'text-slate-600 bg-slate-50',
                                };
                            @endphp
                            <span class="inline-block px-2 py-0.5 text-xs font-semibold {{ $statusClass }}">{{ ucfirst($mhs->status) }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-center gap-1">
                                <button onclick="openDetailModal({{ $mhs->id }})" class="w-8 h-8 flex items-center justify-center text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-all duration-200" title="Detail">
                                    <i class="fa-solid fa-eye text-sm"></i>
                                </button>
                                <button onclick="openEditModal(this)" class="w-8 h-8 flex items-center justify-center text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 transition-all duration-200" title="Edit">
                                    <i class="fa-solid fa-pen-to-square text-sm"></i>
                                </button>
                                <button onclick="confirmDelete({{ $mhs->id }}, '{{ $mhs->nama_lengkap }}')" class="w-8 h-8 flex items-center justify-center text-slate-400 hover:text-red-600 hover:bg-red-50 transition-all duration-200" title="Hapus">
                                    <i class="fa-solid fa-trash-can text-sm"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-12 text-center text-sm text-slate-400">
                            Tidak ada data mahasiswa.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-4 py-3 border-t border-slate-100">
            {{ $mahasiswas->withQueryString()->links() }}
        </div>
    </div>
</div>

<x-app-modal id="createModal" maxWidth="2xl" title="Tambah Mahasiswa Baru" icon='<svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>' iconColor="emerald">
    <form id="createForm" method="POST" action="{{ route('admin.mahasiswa.store') }}">
        @csrf
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="create_nim">NIM</label>
                <input id="create_nim" type="text" name="nim" placeholder="Masukkan NIM" required>
            </div>
            <div>
                <label for="create_nama_lengkap">Nama Lengkap</label>
                <input id="create_nama_lengkap" type="text" name="nama_lengkap" placeholder="Masukkan nama" required>
            </div>
            <div>
                <label for="create_angkatan">Angkatan</label>
                <input id="create_angkatan" type="number" name="angkatan" placeholder="Contoh: 2023" required>
            </div>
            <div>
                <label for="create_program_studi">Program Studi</label>
                <input id="create_program_studi" type="text" name="program_studi" placeholder="Contoh: Sistem Informasi" required>
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
                <label for="create_status">Status</label>
                <select id="create_status" name="status" required>
                    <option value="aktif">Aktif</option>
                    <option value="cuti">Cuti</option>
                    <option value="lulus">Lulus</option>
                    <option value="dropout">Dropout</option>
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

<x-app-modal id="editModal" maxWidth="2xl" title="Edit Mahasiswa" icon='<svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>' iconColor="emerald">
    <form id="editForm" method="POST">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="edit_nim">NIM</label>
                <input id="edit_nim" type="text" name="nim" required>
            </div>
            <div>
                <label for="edit_nama_lengkap">Nama Lengkap</label>
                <input id="edit_nama_lengkap" type="text" name="nama_lengkap" required>
            </div>
            <div>
                <label for="edit_angkatan">Angkatan</label>
                <input id="edit_angkatan" type="number" name="angkatan" required>
            </div>
            <div>
                <label for="edit_program_studi">Program Studi</label>
                <input id="edit_program_studi" type="text" name="program_studi" required>
            </div>
            <div>
                <label for="edit_jenis_kelamin">Jenis Kelamin</label>
                <select id="edit_jenis_kelamin" name="jenis_kelamin" required>
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                </select>
            </div>
            <div>
                <label for="edit_status">Status</label>
                <select id="edit_status" name="status" required>
                    <option value="aktif">Aktif</option>
                    <option value="cuti">Cuti</option>
                    <option value="lulus">Lulus</option>
                    <option value="dropout">Dropout</option>
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

<x-app-modal id="detailModal" maxWidth="2xl" title="Detail Mahasiswa" icon='<svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>' iconColor="emerald">
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

    document.getElementById('editForm').action = `/admin/mahasiswa/${data.id}`;
    document.getElementById('edit_nim').value = data.nim;
    document.getElementById('edit_nama_lengkap').value = data.nama_lengkap;
    document.getElementById('edit_angkatan').value = data.angkatan;
    document.getElementById('edit_program_studi').value = data.program_studi;
    document.getElementById('edit_jenis_kelamin').value = data.jenis_kelamin;
    document.getElementById('edit_status').value = data.status;
    document.getElementById('edit_email').value = data.email || '';
    document.getElementById('edit_no_hp').value = data.no_hp || '';
    document.getElementById('edit_alamat').value = data.alamat || '';
    document.getElementById('edit_password').value = '';

    AppModal.open('editModal');
}

function openDetailModal(id) {
    const tr = document.querySelector(`button[onclick="openDetailModal(${id})"]`)?.closest('tr');
    const data = tr ? JSON.parse(tr.getAttribute('data-detail-json') || '{}') : {};
    const statusClass = { 'aktif': 'text-emerald-600', 'cuti': 'text-amber-600', 'lulus': 'text-blue-600', 'dropout': 'text-red-600' }[data.status] || 'text-slate-600';

    document.getElementById('detailContent').innerHTML = `
        <div class="grid grid-cols-2 gap-4">
            <div><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">NIM</p><p class="text-slate-900 font-mono mt-1">${data.nim || '-'}</p></div>
            <div><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Nama Lengkap</p><p class="text-slate-900 mt-1">${data.nama_lengkap || '-'}</p></div>
            <div><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Program Studi</p><p class="text-slate-900 mt-1">${data.program_studi || '-'}</p></div>
            <div><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Angkatan</p><p class="text-slate-900 mt-1">${data.angkatan || '-'}</p></div>
            <div><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Jenis Kelamin</p><p class="text-slate-900 mt-1">${data.jenis_kelamin || '-'}</p></div>
            <div><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Status</p><p class="mt-1"><span class="font-semibold text-xs ${statusClass}">${data.status ? data.status.charAt(0).toUpperCase() + data.status.slice(1) : '-'}</span></p></div>
            <div><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Email</p><p class="text-slate-900 mt-1">${data.email || '-'}</p></div>
            <div><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">No. HP</p><p class="text-slate-900 mt-1">${data.no_hp || '-'}</p></div>
            <div class="col-span-2"><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Alamat</p><p class="text-slate-900 mt-1">${data.alamat || '-'}</p></div>
            <div><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Dibuat Pada</p><p class="text-slate-900 mt-1">${data.created_at || '-'}</p></div>
            <div><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Akun Terkait</p><p class="text-slate-900 mt-1 font-mono text-xs">${data.identifier || '-'}</p></div>
        </div>
    `;
    AppModal.open('detailModal');
}

function confirmDelete(id, name) {
    AppPopup.confirm({
        title: 'Hapus Mahasiswa',
        description: `Apakah Anda yakin ingin menghapus "${name}"? Semua data terkait akan ikut terhapus.`,
        confirmText: 'Ya, Hapus',
        cancelText: 'Batal',
        onConfirm: () => {
            document.getElementById('deleteForm').action = `/admin/mahasiswa/${id}`;
            document.getElementById('deleteForm').submit();
        }
    });
}
</script>
@endpush
