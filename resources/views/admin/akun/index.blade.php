@extends('dashboard.layouts.main')

@section('content')
<div class="animate-fade-in">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-lg font-bold text-slate-900">Manajemen Akun</h1>
            <p class="text-sm text-slate-500">Kelola semua akun pengguna dalam sistem.</p>
        </div>
        <button onclick="openCreateModal()" class="inline-flex items-center gap-2 px-4 py-2.5 bg-slate-900 text-white text-xs font-bold tracking-wide hover:bg-slate-700 transition-colors duration-200">
            <i class="fa-solid fa-plus"></i>
            Tambah Akun
        </button>
    </div>

    <div class="bg-white border border-slate-200">
        <div class="p-4 border-b border-slate-100">
            <form method="GET" action="{{ route('admin.akun.index') }}">
                <div class="flex gap-3">
                    <div class="relative flex-1">
                        <i class="fa-solid fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari identifier atau nama..." class="w-full pl-9 pr-4 py-2 border border-slate-200 text-sm focus:outline-none focus:border-slate-900 transition-colors duration-200">
                    </div>
                    <button type="submit" class="px-4 py-2 bg-slate-900 text-white text-xs font-bold tracking-wide hover:bg-slate-700 transition-colors duration-200">Cari</button>
                    @if(request('search'))
                        <a href="{{ route('admin.akun.index') }}" class="px-4 py-2 border border-slate-200 text-slate-600 text-xs font-bold tracking-wide hover:bg-slate-50 transition-colors duration-200">Reset</a>
                    @endif
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100">
                        <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Identifier</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Nama</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Role</th>
                        <th class="text-center px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="text-center px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $user)
                    <tr class="hover:bg-slate-50 transition-colors duration-150"
                        data-edit-json="{{ json_encode([
                            'id' => $user->id,
                            'identifier' => $user->identifier,
                            'name' => $user->name,
                            'role' => $user->roles->first()?->name ?? '',
                        ]) }}"
                        data-detail-json="{{ json_encode([
                            'identifier' => $user->identifier,
                            'name' => $user->name,
                            'role' => $user->roles->first()?->name ?? '',
                            'is_active' => $user->is_active,
                            'last_login_at' => $user->last_login_at?->format('d M Y H:i'),
                            'created_at' => $user->created_at->format('d M Y H:i'),
                        ]) }}">
                        <td class="px-4 py-3 font-mono text-sm text-slate-900">{{ $user->identifier }}</td>
                        <td class="px-4 py-3 text-sm text-slate-700">{{ $user->name }}</td>
                        <td class="px-4 py-3">
                            @foreach($user->roles as $role)
                                @php
                                    $badgeClass = match($role->name) {
                                        'admin' => 'bg-indigo-100 text-indigo-700',
                                        'dosen' => 'bg-emerald-100 text-emerald-700',
                                        'mahasiswa' => 'bg-amber-100 text-amber-700',
                                        default => 'bg-slate-100 text-slate-700',
                                    };
                                @endphp
                                <span class="inline-block px-2 py-0.5 text-xs font-semibold {{ $badgeClass }}">{{ ucfirst($role->name) }}</span>
                            @endforeach
                        </td>
                        <td class="px-4 py-3 text-center">
                            @if($user->is_active)
                                <span class="inline-flex items-center gap-1 text-xs font-semibold text-emerald-600">
                                    <span class="w-1.5 h-1.5 bg-emerald-500"></span>
                                    Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 text-xs font-semibold text-red-500">
                                    <span class="w-1.5 h-1.5 bg-red-500"></span>
                                    Nonaktif
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-center gap-1">
                                <button onclick="openDetailModal({{ $user->id }})" class="w-8 h-8 flex items-center justify-center text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-all duration-200" title="Detail">
                                    <i class="fa-solid fa-eye text-sm"></i>
                                </button>
                                <button onclick="openEditModal(this)" class="w-8 h-8 flex items-center justify-center text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 transition-all duration-200" title="Edit">
                                    <i class="fa-solid fa-pen-to-square text-sm"></i>
                                </button>
                                <button onclick="confirmToggleActive({{ $user->id }}, '{{ $user->name }}', {{ $user->is_active ? 'true' : 'false' }})" class="w-8 h-8 flex items-center justify-center text-slate-400 hover:text-amber-600 hover:bg-amber-50 transition-all duration-200" title="{{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                    <i class="fa-solid {{ $user->is_active ? 'fa-ban' : 'fa-check' }} text-sm"></i>
                                </button>
                                @if(!$user->isAdmin())
                                <button onclick="confirmDelete({{ $user->id }}, '{{ $user->name }}')" class="w-8 h-8 flex items-center justify-center text-slate-400 hover:text-red-600 hover:bg-red-50 transition-all duration-200" title="Hapus">
                                    <i class="fa-solid fa-trash-can text-sm"></i>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-12 text-center text-sm text-slate-400">
                            Tidak ada data akun.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-4 py-3 border-t border-slate-100">
            {{ $users->withQueryString()->links() }}
        </div>
    </div>
</div>

<x-app-modal id="createModal" maxWidth="lg" title="Tambah Akun Baru" icon='<svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>' iconColor="indigo">
    <form id="createForm" method="POST" action="{{ route('admin.akun.store') }}">
        @csrf
        <div class="space-y-4">
            <div>
                <label for="create_identifier">NIM / Username</label>
                <input id="create_identifier" type="text" name="identifier" placeholder="Masukkan NIM atau username" required>
            </div>
            <div>
                <label for="create_name">Nama Lengkap</label>
                <input id="create_name" type="text" name="name" placeholder="Masukkan nama lengkap" required>
            </div>
            <div>
                <label for="create_password">Kata Sandi</label>
                <input id="create_password" type="password" name="password" placeholder="Minimal 6 karakter" required>
            </div>
            <div>
                <label for="create_role">Role</label>
                <select id="create_role" name="role" required>
                    <option value="">Pilih Role</option>
                    <option value="admin">Admin</option>
                    <option value="dosen">Dosen</option>
                    <option value="mahasiswa">Mahasiswa</option>
                </select>
            </div>
        </div>
    </form>
    <x-slot name="footer">
        <button type="button" onclick="AppModal.close('createModal')" class="modal-btn-cancel">Batal</button>
        <button type="submit" form="createForm" class="modal-btn-primary">Simpan</button>
    </x-slot>
</x-app-modal>

<x-app-modal id="editModal" maxWidth="lg" title="Edit Akun" icon='<svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>' iconColor="indigo">
    <form id="editForm" method="POST">
        @csrf
        @method('PUT')
        <div class="space-y-4">
            <div>
                <label for="edit_identifier">NIM / Username</label>
                <input id="edit_identifier" type="text" name="identifier" placeholder="Masukkan NIM atau username" required>
            </div>
            <div>
                <label for="edit_name">Nama Lengkap</label>
                <input id="edit_name" type="text" name="name" placeholder="Masukkan nama lengkap" required>
            </div>
            <div>
                <label for="edit_password">Kata Sandi <span class="text-slate-400 lowercase">(kosongkan jika tidak diubah)</span></label>
                <input id="edit_password" type="password" name="password" placeholder="Minimal 6 karakter">
            </div>
            <div>
                <label for="edit_role">Role</label>
                <select id="edit_role" name="role" required>
                    <option value="">Pilih Role</option>
                    <option value="admin">Admin</option>
                    <option value="dosen">Dosen</option>
                    <option value="mahasiswa">Mahasiswa</option>
                </select>
            </div>
        </div>
    </form>
    <x-slot name="footer">
        <button type="button" onclick="AppModal.close('editModal')" class="modal-btn-cancel">Batal</button>
        <button type="submit" form="editForm" class="modal-btn-primary">Simpan</button>
    </x-slot>
</x-app-modal>

<x-app-modal id="detailModal" maxWidth="lg" title="Detail Akun" icon='<svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>' iconColor="indigo">
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

<form id="toggleForm" method="POST" class="hidden">
    @csrf
    @method('PATCH')
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

    document.getElementById('editForm').action = `/admin/akun/${data.id}`;
    document.getElementById('edit_identifier').value = data.identifier;
    document.getElementById('edit_name').value = data.name;
    document.getElementById('edit_role').value = data.role || '';
    document.getElementById('edit_password').value = '';

    AppModal.open('editModal');
}

function openDetailModal(id) {
    const tr = document.querySelector(`button[onclick="openDetailModal(${id})"]`)?.closest('tr');
    const data = tr ? JSON.parse(tr.getAttribute('data-detail-json') || '{}') : {};

    document.getElementById('detailContent').innerHTML = `
        <div class="grid grid-cols-2 gap-4">
            <div><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Identifier</p><p class="text-slate-900 font-mono mt-1">${data.identifier || '-'}</p></div>
            <div><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Nama</p><p class="text-slate-900 mt-1">${data.name || '-'}</p></div>
            <div><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Role</p><p class="mt-1"><span class="inline-block px-2 py-0.5 text-xs font-semibold bg-indigo-100 text-indigo-700">${data.role ? data.role.charAt(0).toUpperCase() + data.role.slice(1) : '-'}</span></p></div>
            <div><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Status</p><p class="mt-1"><span class="font-semibold text-xs ${data.is_active ? 'text-emerald-600' : 'text-red-500'}">${data.is_active ? 'Aktif' : 'Nonaktif'}</span></p></div>
            <div><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Terakhir Login</p><p class="text-slate-900 mt-1">${data.last_login_at || 'Belum pernah'}</p></div>
            <div><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Dibuat Pada</p><p class="text-slate-900 mt-1">${data.created_at || '-'}</p></div>
        </div>
    `;
    AppModal.open('detailModal');
}

function confirmToggleActive(id, name, isActive) {
    const action = isActive ? 'nonaktifkan' : 'aktifkan';
    AppPopup.confirm({
        title: `${isActive ? 'Nonaktifkan' : 'Aktifkan'} Akun`,
        description: `Apakah Anda yakin ingin ${action} akun "${name}"?`,
        confirmText: `Ya, ${isActive ? 'Nonaktifkan' : 'Aktifkan'}`,
        cancelText: 'Batal',
        onConfirm: () => {
            document.getElementById('toggleForm').action = `/admin/akun/${id}/toggle-active`;
            document.getElementById('toggleForm').submit();
        }
    });
}

function confirmDelete(id, name) {
    AppPopup.confirm({
        title: 'Hapus Akun',
        description: `Apakah Anda yakin ingin menghapus akun "${name}"? Tindakan ini tidak dapat dibatalkan.`,
        confirmText: 'Ya, Hapus',
        cancelText: 'Batal',
        onConfirm: () => {
            document.getElementById('deleteForm').action = `/admin/akun/${id}`;
            document.getElementById('deleteForm').submit();
        }
    });
}
</script>
@endpush
