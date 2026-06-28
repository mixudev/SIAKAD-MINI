<div data-detail-content>
    <script type="application/json" data-user-json>@json([
        'id' => $user->id,
        'identifier' => $user->identifier,
        'name' => $user->name,
        'is_active' => $user->is_active,
        'role' => $user->roles->first()?->name ?? '',
        'last_login_at' => $user->last_login_at?->format('d M Y H:i'),
        'created_at' => $user->created_at->format('d M Y H:i'),
    ])</script>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Identifier</p>
            <p class="text-slate-900 font-mono mt-1">{{ $user->identifier }}</p>
        </div>
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Nama</p>
            <p class="text-slate-900 mt-1">{{ $user->name }}</p>
        </div>
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Role</p>
            <p class="mt-1">
                @foreach($user->roles as $role)
                    <span class="inline-block px-2 py-0.5 text-xs font-semibold bg-indigo-100 text-indigo-700">{{ ucfirst($role->name) }}</span>
                @endforeach
            </p>
        </div>
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Status</p>
            <p class="mt-1">
                @if($user->is_active)
                    <span class="text-emerald-600 font-semibold text-xs">Aktif</span>
                @else
                    <span class="text-red-500 font-semibold text-xs">Nonaktif</span>
                @endif
            </p>
        </div>
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Terakhir Login</p>
            <p class="text-slate-900 mt-1">{{ $user->last_login_at?->format('d M Y H:i') ?? 'Belum pernah' }}</p>
        </div>
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Dibuat Pada</p>
            <p class="text-slate-900 mt-1">{{ $user->created_at->format('d M Y H:i') }}</p>
        </div>
    </div>
</div>
