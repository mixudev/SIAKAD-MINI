@extends('docs.layouts.main')
@section('title', 'Dokumentasi — SIAKAD Mini')
@section('breadcrumb')
    <span>Beranda</span>
@endsection
@section('content')
<div class="text-center py-4">
    <div class="w-14 h-14 bg-amber-100 flex items-center justify-center mx-auto mb-5">
        <i class="fas fa-book-open text-xl text-amber-700"></i>
    </div>
    <h2 class="!border-0 !pb-0 !mt-0">Dokumentasi SIAKAD Mini</h2>
    <p class="text-stone-500 max-w-lg mx-auto !mb-10">Panduan lengkap penggunaan sistem untuk Mahasiswa, Dosen, dan Admin. Pilih peran Anda di bawah.</p>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 max-w-2xl mx-auto !mb-0">
        <a href="{{ route('docs.show', 'mahasiswa') }}" class="block border border-stone-200 p-6 hover:border-amber-700 hover:bg-stone-50 transition-all text-left !no-underline">
            <div class="w-10 h-10 bg-amber-100 flex items-center justify-center mb-4">
                <i class="fas fa-user-graduate text-amber-700"></i>
            </div>
            <h3 class="!mt-0 !mb-1 text-stone-900 font-semibold">Mahasiswa</h3>
            <p class="text-sm text-stone-500 !mb-0">KRS, KHS, Dashboard</p>
        </a>
        <a href="{{ route('docs.show', 'dosen') }}" class="block border border-stone-200 p-6 hover:border-amber-700 hover:bg-stone-50 transition-all text-left !no-underline">
            <div class="w-10 h-10 bg-amber-100 flex items-center justify-center mb-4">
                <i class="fas fa-chalkboard-teacher text-amber-700"></i>
            </div>
            <h3 class="!mt-0 !mb-1 text-stone-900 font-semibold">Dosen</h3>
            <p class="text-sm text-stone-500 !mb-0">Input Nilai, Dashboard</p>
        </a>
        <a href="{{ route('docs.show', 'admin') }}" class="block border border-stone-200 p-6 hover:border-amber-700 hover:bg-stone-50 transition-all text-left !no-underline">
            <div class="w-10 h-10 bg-amber-100 flex items-center justify-center mb-4">
                <i class="fas fa-user-shield text-amber-700"></i>
            </div>
            <h3 class="!mt-0 !mb-1 text-stone-900 font-semibold">Admin</h3>
            <p class="text-sm text-stone-500 !mb-0">Manajemen data, Akademik</p>
        </a>
    </div>

    <div class="mt-8 border-t border-stone-200 pt-8 max-w-lg mx-auto">
        <a href="{{ url('/login') }}" class="inline-flex items-center gap-2 text-sm text-amber-700 hover:text-amber-900 transition-colors font-medium !no-underline border border-amber-700 px-5 py-2.5 hover:bg-amber-50">
            <i class="fas fa-sign-in-alt"></i>
            Login ke Aplikasi
        </a>
    </div>
</div>
@endsection
