@extends('dashboard.layouts.main')

@section('content')
<div class="animate-fade-in">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-lg font-bold text-slate-900">Manajemen Kelas Mata Kuliah</h1>
            <p class="text-sm text-slate-500">Kelola kelas mata kuliah, dosen pengampu, dan jadwal.</p>
        </div>
        <button onclick="openCreateModal()" class="inline-flex items-center gap-2 px-4 py-2.5 bg-slate-900 text-white text-xs font-bold tracking-wide hover:bg-slate-700 transition-colors duration-200">
            <i class="fa-solid fa-plus"></i>
            Tambah Kelas Matkul
        </button>
    </div>

    <div class="bg-white border border-slate-200">
        <div class="p-4 border-b border-slate-100">
            <form method="GET" action="{{ route('admin.kelas-matkul.index') }}">
                <div class="flex gap-3">
                    <div class="relative flex-1">
                        <i class="fa-solid fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari matkul, dosen, atau kelas..." class="w-full pl-9 pr-4 py-2 border border-slate-200 text-sm focus:outline-none focus:border-slate-900 transition-colors duration-200">
                    </div>
                    <button type="submit" class="px-4 py-2 bg-slate-900 text-white text-xs font-bold tracking-wide hover:bg-slate-700 transition-colors duration-200">Cari</button>
                    @if(request('search'))
                        <a href="{{ route('admin.kelas-matkul.index') }}" class="px-4 py-2 border border-slate-200 text-slate-600 text-xs font-bold tracking-wide hover:bg-slate-50 transition-colors duration-200">Reset</a>
                    @endif
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100">
                        <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Mata Kuliah</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Dosen</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Semester</th>
                        <th class="text-center px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Kelas</th>
                        <th class="text-center px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Kapasitas</th>
                        <th class="text-center px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($kelasMatkuls as $km)
                    <tr class="hover:bg-slate-50 transition-colors duration-150"
                        data-edit-json="{{ json_encode([
                            'id' => $km->id,
                            'mata_kuliah_id' => $km->mata_kuliah_id,
                            'dosen_id' => $km->dosen_id,
                            'semester_id' => $km->semester_id,
                            'nama_kelas' => $km->nama_kelas,
                            'kapasitas' => $km->kapasitas,
                            'hari' => $km->hari,
                            'jam_mulai' => $km->jam_mulai,
                            'jam_selesai' => $km->jam_selesai,
                            'ruangan' => $km->ruangan,
                            'matkul_nama' => $km->mataKuliah?->nama ?? '',
                            'dosen_nama' => $km->dosen?->nama_lengkap ?? '',
                            'semester_nama' => $km->semester?->nama ?? '',
                        ]) }}"
                        data-detail-json="{{ json_encode([
                            'matkul_nama' => $km->mataKuliah?->nama ?? '-',
                            'dosen_nama' => $km->dosen?->nama_lengkap ?? '-',
                            'semester_nama' => $km->semester?->nama ?? '-',
                            'nama_kelas' => $km->nama_kelas,
                            'kapasitas' => $km->kapasitas,
                            'hari' => $km->hari,
                            'jam_mulai' => $km->jam_mulai,
                            'jam_selesai' => $km->jam_selesai,
                            'ruangan' => $km->ruangan,
                            'created_at' => $km->created_at->format('d M Y H:i'),
                        ]) }}">
                        <td class="px-4 py-3 text-sm text-slate-700">{{ $km->mataKuliah?->nama ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm text-slate-600">{{ $km->dosen?->nama_lengkap ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm text-slate-600">{{ $km->semester?->nama ?? '-' }}</td>
                        <td class="px-4 py-3 text-center font-semibold text-slate-900">{{ $km->nama_kelas }}</td>
                        <td class="px-4 py-3 text-center text-sm text-slate-600">{{ $km->jumlahPeserta() }} / {{ $km->kapasitas }}</td>
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-center gap-1">
                                <button onclick="openDetailModal({{ $km->id }})" class="w-8 h-8 flex items-center justify-center text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-all duration-200" title="Detail">
                                    <i class="fa-solid fa-eye text-sm"></i>
                                </button>
                                <button onclick="openEditModal(this)" class="w-8 h-8 flex items-center justify-center text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 transition-all duration-200" title="Edit">
                                    <i class="fa-solid fa-pen-to-square text-sm"></i>
                                </button>
                                <button onclick="confirmDelete({{ $km->id }}, '{{ $km->mataKuliah?->nama }} - {{ $km->nama_kelas }}')" class="w-8 h-8 flex items-center justify-center text-slate-400 hover:text-red-600 hover:bg-red-50 transition-all duration-200" title="Hapus">
                                    <i class="fa-solid fa-trash-can text-sm"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-12 text-center text-sm text-slate-400">
                            Tidak ada data kelas matkul.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-4 py-3 border-t border-slate-100">
            {{ $kelasMatkuls->withQueryString()->links() }}
        </div>
    </div>
</div>

<x-app-modal id="createModal" maxWidth="2xl" title="Tambah Kelas Matkul Baru" icon='<svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" viewBox="0 0 24 24"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>' iconColor="indigo">
    <form id="createForm" method="POST" action="{{ route('admin.kelas-matkul.store') }}">
        @csrf
        <div class="grid grid-cols-2 gap-4">
            <div class="col-span-2">
                <label for="create_mata_kuliah_id">Mata Kuliah</label>
                <select id="create_mata_kuliah_id" name="mata_kuliah_id" required>
                    <option value="">Pilih Mata Kuliah</option>
                    @foreach($mataKuliahs as $mk)
                        <option value="{{ $mk->id }}">{{ $mk->kode }} - {{ $mk->nama }} ({{ $mk->sks }} SKS)</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="create_dosen_id">Dosen Pengampu</label>
                <select id="create_dosen_id" name="dosen_id" required>
                    <option value="">Pilih Dosen</option>
                    @foreach($dosens as $dosen)
                        <option value="{{ $dosen->id }}">{{ $dosen->nama_lengkap }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="create_semester_id">Semester</label>
                <select id="create_semester_id" name="semester_id" required>
                    <option value="">Pilih Semester</option>
                    @foreach($semesters as $s)
                        <option value="{{ $s->id }}">{{ $s->nama }} ({{ $s->tahun_ajaran }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="create_nama_kelas">Nama Kelas</label>
                <input id="create_nama_kelas" type="text" name="nama_kelas" placeholder="Contoh: A" required>
            </div>
            <div>
                <label for="create_kapasitas">Kapasitas</label>
                <input id="create_kapasitas" type="number" name="kapasitas" placeholder="Contoh: 40" min="1" max="200" required>
            </div>
            <div>
                <label for="create_hari">Hari</label>
                <select id="create_hari" name="hari">
                    <option value="">Pilih Hari</option>
                    <option value="Senin">Senin</option>
                    <option value="Selasa">Selasa</option>
                    <option value="Rabu">Rabu</option>
                    <option value="Kamis">Kamis</option>
                    <option value="Jumat">Jumat</option>
                    <option value="Sabtu">Sabtu</option>
                </select>
            </div>
            <div>
                <label for="create_jam_mulai">Jam Mulai</label>
                <input id="create_jam_mulai" type="time" name="jam_mulai">
            </div>
            <div>
                <label for="create_jam_selesai">Jam Selesai</label>
                <input id="create_jam_selesai" type="time" name="jam_selesai">
            </div>
            <div>
                <label for="create_ruangan">Ruangan</label>
                <input id="create_ruangan" type="text" name="ruangan" placeholder="Contoh: R.101">
            </div>
        </div>
    </form>
    <x-slot name="footer">
        <button type="button" onclick="AppModal.close('createModal')" class="modal-btn-cancel">Batal</button>
        <button type="submit" form="createForm" class="modal-btn-primary">Simpan</button>
    </x-slot>
</x-app-modal>

<x-app-modal id="editModal" maxWidth="2xl" title="Edit Kelas Matkul" icon='<svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>' iconColor="indigo">
    <form id="editForm" method="POST">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-2 gap-4">
            <div class="col-span-2">
                <label for="edit_mata_kuliah_id">Mata Kuliah</label>
                <select id="edit_mata_kuliah_id" name="mata_kuliah_id" required>
                    <option value="">Pilih Mata Kuliah</option>
                    @foreach($mataKuliahs as $mk)
                        <option value="{{ $mk->id }}">{{ $mk->kode }} - {{ $mk->nama }} ({{ $mk->sks }} SKS)</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="edit_dosen_id">Dosen Pengampu</label>
                <select id="edit_dosen_id" name="dosen_id" required>
                    <option value="">Pilih Dosen</option>
                    @foreach($dosens as $dosen)
                        <option value="{{ $dosen->id }}">{{ $dosen->nama_lengkap }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="edit_semester_id">Semester</label>
                <select id="edit_semester_id" name="semester_id" required>
                    <option value="">Pilih Semester</option>
                    @foreach($semesters as $s)
                        <option value="{{ $s->id }}">{{ $s->nama }} ({{ $s->tahun_ajaran }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="edit_nama_kelas">Nama Kelas</label>
                <input id="edit_nama_kelas" type="text" name="nama_kelas" required>
            </div>
            <div>
                <label for="edit_kapasitas">Kapasitas</label>
                <input id="edit_kapasitas" type="number" name="kapasitas" min="1" max="200" required>
            </div>
            <div>
                <label for="edit_hari">Hari</label>
                <select id="edit_hari" name="hari">
                    <option value="">Pilih Hari</option>
                    <option value="Senin">Senin</option>
                    <option value="Selasa">Selasa</option>
                    <option value="Rabu">Rabu</option>
                    <option value="Kamis">Kamis</option>
                    <option value="Jumat">Jumat</option>
                    <option value="Sabtu">Sabtu</option>
                </select>
            </div>
            <div>
                <label for="edit_jam_mulai">Jam Mulai</label>
                <input id="edit_jam_mulai" type="time" name="jam_mulai">
            </div>
            <div>
                <label for="edit_jam_selesai">Jam Selesai</label>
                <input id="edit_jam_selesai" type="time" name="jam_selesai">
            </div>
            <div>
                <label for="edit_ruangan">Ruangan</label>
                <input id="edit_ruangan" type="text" name="ruangan">
            </div>
        </div>
    </form>
    <x-slot name="footer">
        <button type="button" onclick="AppModal.close('editModal')" class="modal-btn-cancel">Batal</button>
        <button type="submit" form="editForm" class="modal-btn-primary">Simpan</button>
    </x-slot>
</x-app-modal>

<x-app-modal id="detailModal" maxWidth="2xl" title="Detail Kelas Matkul" icon='<svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" viewBox="0 0 24 24"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>' iconColor="indigo">
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

    document.getElementById('editForm').action = `/admin/kelas-matkul/${data.id}`;
    document.getElementById('edit_mata_kuliah_id').value = data.mata_kuliah_id;
    document.getElementById('edit_dosen_id').value = data.dosen_id;
    document.getElementById('edit_semester_id').value = data.semester_id;
    document.getElementById('edit_nama_kelas').value = data.nama_kelas;
    document.getElementById('edit_kapasitas').value = data.kapasitas;
    document.getElementById('edit_hari').value = data.hari || '';
    document.getElementById('edit_jam_mulai').value = data.jam_mulai || '';
    document.getElementById('edit_jam_selesai').value = data.jam_selesai || '';
    document.getElementById('edit_ruangan').value = data.ruangan || '';

    AppModal.open('editModal');
}

function openDetailModal(id) {
    const tr = document.querySelector(`button[onclick="openDetailModal(${id})"]`)?.closest('tr');
    const data = tr ? JSON.parse(tr.getAttribute('data-detail-json') || '{}') : {};

    document.getElementById('detailContent').innerHTML = `
        <div class="grid grid-cols-2 gap-4">
            <div><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Mata Kuliah</p><p class="text-slate-900 mt-1">${data.matkul_nama || '-'}</p></div>
            <div><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Dosen Pengampu</p><p class="text-slate-900 mt-1">${data.dosen_nama || '-'}</p></div>
            <div><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Semester</p><p class="text-slate-900 mt-1">${data.semester_nama || '-'}</p></div>
            <div><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Nama Kelas</p><p class="text-slate-900 mt-1 font-semibold">${data.nama_kelas || '-'}</p></div>
            <div><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Kapasitas</p><p class="text-slate-900 mt-1">${data.kapasitas || '-'} Mahasiswa</p></div>
            <div><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Hari</p><p class="text-slate-900 mt-1">${data.hari || '-'}</p></div>
            <div><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Jam Mulai</p><p class="text-slate-900 mt-1">${data.jam_mulai || '-'}</p></div>
            <div><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Jam Selesai</p><p class="text-slate-900 mt-1">${data.jam_selesai || '-'}</p></div>
            <div><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Ruangan</p><p class="text-slate-900 mt-1">${data.ruangan || '-'}</p></div>
            <div><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Dibuat Pada</p><p class="text-slate-900 mt-1">${data.created_at || '-'}</p></div>
        </div>
    `;
    AppModal.open('detailModal');
}

function confirmDelete(id, name) {
    AppPopup.confirm({
        title: 'Hapus Kelas Matkul',
        description: `Apakah Anda yakin ingin menghapus "${name}"?`,
        confirmText: 'Ya, Hapus',
        cancelText: 'Batal',
        onConfirm: () => {
            document.getElementById('deleteForm').action = `/admin/kelas-matkul/${id}`;
            document.getElementById('deleteForm').submit();
        }
    });
}
</script>
@endpush
