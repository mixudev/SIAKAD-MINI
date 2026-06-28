<div data-detail-content>
    <script type="application/json" data-semester-json>@json([
        'nama' => $semester->nama,
        'tahun_ajaran' => $semester->tahun_ajaran,
        'tipe' => $semester->tipe,
        'tanggal_mulai' => $semester->tanggal_mulai?->format('d M Y'),
        'tanggal_selesai' => $semester->tanggal_selesai?->format('d M Y'),
        'krs_mulai' => $semester->krs_mulai?->format('d M Y'),
        'krs_selesai' => $semester->krs_selesai?->format('d M Y'),
        'is_active' => $semester->is_active,
        'created_at' => $semester->created_at->format('d M Y H:i'),
    ])</script>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Nama Semester</p>
            <p class="text-slate-900 mt-1">{{ $semester->nama }}</p>
        </div>
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Tahun Ajaran</p>
            <p class="text-slate-900 mt-1">{{ $semester->tahun_ajaran }}</p>
        </div>
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Tipe</p>
            <p class="mt-1"><span class="inline-block px-2 py-0.5 text-xs font-semibold uppercase {{ $semester->tipe === 'ganjil' ? 'bg-purple-100 text-purple-700' : 'bg-orange-100 text-orange-700' }}">{{ $semester->tipe }}</span></p>
        </div>
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Status</p>
            <p class="mt-1">
                @if($semester->is_active)
                    <span class="inline-flex items-center gap-1 text-xs font-semibold text-emerald-600"><span class="w-1.5 h-1.5 bg-emerald-500"></span>Aktif</span>
                @else
                    <span class="text-xs font-semibold text-slate-400">Tidak Aktif</span>
                @endif
            </p>
        </div>
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Tanggal Mulai</p>
            <p class="text-slate-900 mt-1">{{ $semester->tanggal_mulai?->format('d M Y') ?? '-' }}</p>
        </div>
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Tanggal Selesai</p>
            <p class="text-slate-900 mt-1">{{ $semester->tanggal_selesai?->format('d M Y') ?? '-' }}</p>
        </div>
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">KRS Mulai</p>
            <p class="text-slate-900 mt-1">{{ $semester->krs_mulai?->format('d M Y') ?? '-' }}</p>
        </div>
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">KRS Selesai</p>
            <p class="text-slate-900 mt-1">{{ $semester->krs_selesai?->format('d M Y') ?? '-' }}</p>
        </div>
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Dibuat Pada</p>
            <p class="text-slate-900 mt-1">{{ $semester->created_at->format('d M Y H:i') }}</p>
        </div>
    </div>
</div>
