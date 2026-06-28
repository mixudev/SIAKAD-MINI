<div data-detail-content>
    <script type="application/json" data-mhs-json>@json([
        'nim' => $mhs->nim,
        'nama_lengkap' => $mhs->nama_lengkap,
        'angkatan' => $mhs->angkatan,
        'program_studi' => $mhs->program_studi,
        'jenis_kelamin' => $mhs->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan',
        'status' => $mhs->status,
        'email' => $mhs->email,
        'no_hp' => $mhs->no_hp,
        'alamat' => $mhs->alamat,
        'created_at' => $mhs->created_at->format('d M Y H:i'),
    ])</script>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">NIM</p>
            <p class="text-slate-900 font-mono mt-1">{{ $mhs->nim }}</p>
        </div>
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Nama Lengkap</p>
            <p class="text-slate-900 mt-1">{{ $mhs->nama_lengkap }}</p>
        </div>
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Program Studi</p>
            <p class="text-slate-900 mt-1">{{ $mhs->program_studi }}</p>
        </div>
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Angkatan</p>
            <p class="text-slate-900 mt-1">{{ $mhs->angkatan }}</p>
        </div>
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Jenis Kelamin</p>
            <p class="text-slate-900 mt-1">{{ $mhs->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
        </div>
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Status</p>
            <p class="mt-1">
                @php
                    $sc = match($mhs->status) {
                        'aktif' => 'text-emerald-600', 'cuti' => 'text-amber-600',
                        'lulus' => 'text-blue-600', 'dropout' => 'text-red-600',
                        default => 'text-slate-600',
                    };
                @endphp
                <span class="font-semibold text-xs {{ $sc }}">{{ ucfirst($mhs->status) }}</span>
            </p>
        </div>
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Email</p>
            <p class="text-slate-900 mt-1">{{ $mhs->email ?? '-' }}</p>
        </div>
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">No. HP</p>
            <p class="text-slate-900 mt-1">{{ $mhs->no_hp ?? '-' }}</p>
        </div>
        <div class="col-span-2">
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Alamat</p>
            <p class="text-slate-900 mt-1">{{ $mhs->alamat ?? '-' }}</p>
        </div>
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Dibuat Pada</p>
            <p class="text-slate-900 mt-1">{{ $mhs->created_at->format('d M Y H:i') }}</p>
        </div>
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Akun Terkait</p>
            <p class="text-slate-900 mt-1 font-mono text-xs">{{ $mhs->user->identifier ?? '-' }}</p>
        </div>
    </div>
</div>
