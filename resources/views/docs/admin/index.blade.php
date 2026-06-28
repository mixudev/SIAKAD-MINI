@extends('docs.layouts.main')
@section('title', 'Admin — SIAKAD Mini')
@section('breadcrumb')
    <span>Admin</span>
@endsection
@section('content')
<h2>Panduan Admin</h2>

<p>Admin memiliki akses penuh ke seluruh data. Menu terbagi dalam dua grup: Menu Utama (data master) dan Akademik (KRS, Nilai, KHS).</p>

<h3>Fitur Tersedia</h3>
<table>
    <tr><th>Menu</th><th>Fungsi</th></tr>
    <tr><td>Dashboard</td><td>Ringkasan data, grafik analitik, daftar KRS pending</td></tr>
    <tr><td>Akun</td><td>CRUD akun, reset password, aktif/nonaktifkan</td></tr>
    <tr><td>Mahasiswa</td><td>CRUD data mahasiswa</td></tr>
    <tr><td>Dosen</td><td>CRUD data dosen</td></tr>
    <tr><td>Mata Kuliah</td><td>CRUD mata kuliah</td></tr>
    <tr><td>Semester</td><td>CRUD semester, atur semester aktif &amp; periode KRS</td></tr>
    <tr><td>Kelas Matkul</td><td>CRUD kelas perkuliahan, assign dosen dan jadwal</td></tr>
    <tr><td>KRS</td><td>Lihat &amp; setujui/tolak KRS mahasiswa</td></tr>
    <tr><td>Nilai</td><td>Overview nilai per semester &amp; kelas</td></tr>
    <tr><td>KHS</td><td>Lihat KHS mahasiswa mana pun</td></tr>
</table>

<h3>Cara Login</h3>
<ol>
    <li>Buka halaman login</li>
    <li>Identifier: <code>admin</code></li>
    <li>Password: <code>password</code> (default)</li>
    <li>Klik <strong>Login</strong></li>
</ol>

<blockquote>Segera ganti password admin setelah deploy ke production.</blockquote>

<h3>Navigasi</h3>
<p>Sidebar kiri menampilkan Menu Utama (data master) dan Akademik. Gunakan sesuai kebutuhan. Informasi pengguna dan logout di pojok kanan atas.</p>
@endsection
