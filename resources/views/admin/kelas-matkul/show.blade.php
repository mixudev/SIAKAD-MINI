<div data-detail-content>
    <script type="application/json" data-km-json>@json([
        'matkul_nama' => $kelasMatkul->mataKuliah?->nama ?? '-',
        'matkul_kode' => $kelasMatkul->mataKuliah?->kode ?? '-',
        'dosen_nama' => $kelasMatkul->dosen?->nama_lengkap ?? '-',
        'semester_nama' => $kelasMatkul->semester?->nama ?? '-',
        'nama_kelas' => $kelasMatkul->nama_kelas,
        'kapasitas' => $kelasMatkul->kapasitas,
        'hari' => $kelasMatkul->hari,
        'jam_mulai' => $kelasMatkul->jam_mulai,
        'jam_selesai' => $kelasMatkul->jam_selesai,
        'ruangan' => $kelasMatkul->ruangan,
        'created_at' => $kelasMatkul->created_at->format('d M Y H:i'),
    ])</script>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Mata Kuliah</p>
            <p class="text-slate-900 mt-1">{{ $kelasMatkul->mataKuliah?->nama ?? '-' }}</p>
        </div>
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Kode MK</p>
            <p class="text-slate-900 font-mono mt-1">{{ $kelasMatkul->mataKuliah?->kode ?? '-' }}</p>
        </div>
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Dosen Pengampu</p>
            <p class="text-slate-900 mt-1">{{ $kelasMatkul->dosen?->nama_lengkap ?? '-' }}</p>
        </div>
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Semester</p>
            <p class="text-slate-900 mt-1">{{ $kelasMatkul->semester?->nama ?? '-' }}</p>
        </div>
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Nama Kelas</p>
            <p class="text-slate-900 mt-1 font-semibold">{{ $kelasMatkul->nama_kelas }}</p>
        </div>
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Kapasitas</p>
            <p class="text-slate-900 mt-1">{{ $kelasMatkul->kapasitas }} Mahasiswa</p>
        </div>
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Hari</p>
            <p class="text-slate-900 mt-1">{{ $kelasMatkul->hari ?? '-' }}</p>
        </div>
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Jam Mulai</p>
            <p class="text-slate-900 mt-1">{{ $kelasMatkul->jam_mulai ?? '-' }}</p>
        </div>
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Jam Selesai</p>
            <p class="text-slate-900 mt-1">{{ $kelasMatkul->jam_selesai ?? '-' }}</p>
        </div>
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Ruangan</p>
            <p class="text-slate-900 mt-1">{{ $kelasMatkul->ruangan ?? '-' }}</p>
        </div>
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Dibuat Pada</p>
            <p class="text-slate-900 mt-1">{{ $kelasMatkul->created_at->format('d M Y H:i') }}</p>
        </div>
    </div>
</div>
