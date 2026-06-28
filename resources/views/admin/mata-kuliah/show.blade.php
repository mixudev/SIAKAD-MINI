<div data-detail-content>
    <script type="application/json" data-matkul-json>@json([
        'kode' => $mataKuliah->kode,
        'nama' => $mataKuliah->nama,
        'sks' => $mataKuliah->sks,
        'semester_ke' => $mataKuliah->semester_ke,
        'program_studi' => $mataKuliah->program_studi,
        'deskripsi' => $mataKuliah->deskripsi,
        'is_active' => $mataKuliah->is_active,
        'created_at' => $mataKuliah->created_at->format('d M Y H:i'),
    ])</script>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Kode MK</p>
            <p class="text-slate-900 font-mono mt-1">{{ $mataKuliah->kode }}</p>
        </div>
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Nama Mata Kuliah</p>
            <p class="text-slate-900 mt-1">{{ $mataKuliah->nama }}</p>
        </div>
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">SKS</p>
            <p class="text-slate-900 mt-1 font-semibold">{{ $mataKuliah->sks }}</p>
        </div>
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Semester Ke</p>
            <p class="text-slate-900 mt-1">{{ $mataKuliah->semester_ke }}</p>
        </div>
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Program Studi</p>
            <p class="text-slate-900 mt-1">{{ $mataKuliah->program_studi }}</p>
        </div>
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Status</p>
            <p class="mt-1">
                @if($mataKuliah->is_active)
                    <span class="inline-flex items-center gap-1 text-xs font-semibold text-emerald-600"><span class="w-1.5 h-1.5 bg-emerald-500"></span>Aktif</span>
                @else
                    <span class="inline-flex items-center gap-1 text-xs font-semibold text-slate-400"><span class="w-1.5 h-1.5 bg-slate-300"></span>Tidak Aktif</span>
                @endif
            </p>
        </div>
        <div class="col-span-2">
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Deskripsi</p>
            <p class="text-slate-900 mt-1">{{ $mataKuliah->deskripsi ?? '-' }}</p>
        </div>
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Dibuat Pada</p>
            <p class="text-slate-900 mt-1">{{ $mataKuliah->created_at->format('d M Y H:i') }}</p>
        </div>
    </div>
</div>
