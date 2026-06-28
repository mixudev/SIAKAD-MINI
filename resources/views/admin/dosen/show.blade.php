<div data-detail-content>
    <script type="application/json" data-dosen-json>@json([
        'nidn' => $dosen->nidn,
        'nama_lengkap' => $dosen->nama_lengkap,
        'gelar_depan' => $dosen->gelar_depan,
        'gelar_belakang' => $dosen->gelar_belakang,
        'jenis_kelamin' => $dosen->jenis_kelamin,
        'email' => $dosen->email,
        'no_hp' => $dosen->no_hp,
        'alamat' => $dosen->alamat,
        'created_at' => $dosen->created_at->format('d M Y H:i'),
    ])</script>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">NIDN</p>
            <p class="text-slate-900 font-mono mt-1">{{ $dosen->nidn }}</p>
        </div>
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Nama Lengkap</p>
            <p class="text-slate-900 mt-1">{{ $dosen->nama_lengkap }}</p>
        </div>
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Gelar Depan</p>
            <p class="text-slate-900 mt-1">{{ $dosen->gelar_depan ?? '-' }}</p>
        </div>
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Gelar Belakang</p>
            <p class="text-slate-900 mt-1">{{ $dosen->gelar_belakang ?? '-' }}</p>
        </div>
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Jenis Kelamin</p>
            <p class="text-slate-900 mt-1">{{ $dosen->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
        </div>
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Email</p>
            <p class="text-slate-900 mt-1">{{ $dosen->email ?? '-' }}</p>
        </div>
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">No. HP</p>
            <p class="text-slate-900 mt-1">{{ $dosen->no_hp ?? '-' }}</p>
        </div>
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Dibuat Pada</p>
            <p class="text-slate-900 mt-1">{{ $dosen->created_at->format('d M Y H:i') }}</p>
        </div>
        <div class="col-span-2">
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Alamat</p>
            <p class="text-slate-900 mt-1">{{ $dosen->alamat ?? '-' }}</p>
        </div>
    </div>
</div>
