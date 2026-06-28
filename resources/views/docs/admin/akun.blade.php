@extends('docs.layouts.main')
@section('title', 'Manajemen Akun — SIAKAD Mini')
@section('breadcrumb')
    <span>Admin / Akun</span>
@endsection
@section('content')
<h2>Manajemen Akun</h2>

<p>Mengelola akun login semua pengguna. Setiap user punya identifier unik (NIM mahasiswa, NIDN dosen, <code>admin</code> untuk admin).</p>

<h3>Fitur</h3>
<ul>
    <li><strong>Tambah Akun</strong> — Buat akun baru dengan role tertentu</li>
    <li><strong>Edit</strong> — Ubah nama, identifier, atau role</li>
    <li><strong>Reset Password</strong> — Kembalikan ke password default</li>
    <li><strong>Aktif/Nonaktifkan</strong> — Nonaktifkan akun tanpa hapus data</li>
    <li><strong>Detail</strong> — Informasi lengkap akun</li>
</ul>

<h3>Cara Tambah Akun Baru</h3>
<ol>
    <li>Buka menu <strong>Akun</strong> di sidebar</li>
    <li>Klik <strong>Tambah Akun</strong></li>
    <li>Isi identifier, nama, password, dan pilih role</li>
    <li>Klik <strong>Simpan</strong></li>
</ol>

<h3>Nonaktifkan Akun</h3>
<p>Akun nonaktif tidak bisa login. Data terkait tetap tersimpan. Cari akun, klik tombol Nonaktifkan, konfirmasi.</p>

<blockquote>Perubahan role dapat memengaruhi akses pengguna. Lakukan dengan hati-hati.</blockquote>
@endsection
