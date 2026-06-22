@extends('dashboard.layouts.main')

@section('content')
<div class="animate-fade-in">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 lg:gap-6">
        <div class="bg-white border border-slate-200 p-5">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold tracking-wider text-slate-400 uppercase">Kelas Diampu</span>
                <span class="w-8 h-8 bg-indigo-50 flex items-center justify-center text-indigo-600">
                    <i class="fa-solid fa-chalkboard-user text-sm"></i>
                </span>
            </div>
            <p class="text-3xl font-bold text-slate-900">—</p>
            <p class="text-xs text-slate-500 mt-1">Semester ini</p>
        </div>

        <div class="bg-white border border-slate-200 p-5">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold tracking-wider text-slate-400 uppercase">Mahasiswa</span>
                <span class="w-8 h-8 bg-emerald-50 flex items-center justify-center text-emerald-600">
                    <i class="fa-solid fa-user-graduate text-sm"></i>
                </span>
            </div>
            <p class="text-3xl font-bold text-slate-900">—</p>
            <p class="text-xs text-slate-500 mt-1">Total bimbingan</p>
        </div>

        <div class="bg-white border border-slate-200 p-5">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold tracking-wider text-slate-400 uppercase">Nilai</span>
                <span class="w-8 h-8 bg-amber-50 flex items-center justify-center text-amber-600">
                    <i class="fa-solid fa-star-half-stroke text-sm"></i>
                </span>
            </div>
            <p class="text-3xl font-bold text-slate-900">—</p>
            <p class="text-xs text-slate-500 mt-1">Belum diinput</p>
        </div>
    </div>

    <div class="mt-6 bg-white border border-slate-200 p-6">
        <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Selamat Datang, Dosen</h3>
        <p class="text-sm text-slate-500 mt-2">
            Gunakan menu di samping untuk menginput nilai kelas yang Anda ampu.
        </p>
    </div>
</div>
@endsection
