@extends('docs.layouts.main')
@section('title', 'Mahasiswa — SIAKAD Mini')
@section('breadcrumb')
    <span>Mahasiswa</span>
@endsection
@section('content')
<h2>Panduan Mahasiswa</h2>

<p>Sebagai mahasiswa, Anda dapat mengakses Dashboard, Kartu Rencana Studi (KRS), dan Kartu Hasil Studi (KHS). Setelah login, sistem mengarahkan Anda ke dashboard mahasiswa.</p>

<h3>Fitur Tersedia</h3>
<table>
    <tr><th>Menu</th><th>Fungsi</th></tr>
    <tr><td>Dashboard</td><td>Ringkasan akademik: IP semester, total SKS, grafik IP per semester, SKS per semester</td></tr>
    <tr><td>KRS</td><td>Pilih mata kuliah, atur jadwal, ajukan KRS ke admin</td></tr>
    <tr><td>KHS</td><td>Lihat nilai per semester, IP, IPK kumulatif, transkrip</td></tr>
</table>

<h3>Cara Login</h3>
<ol>
    <li>Buka halaman login sistem</li>
    <li>Masukkan <strong>NIM</strong> sebagai identifier (contoh: <code>220101001</code>)</li>
    <li>Masukkan password (default: <code>password</code>)</li>
    <li>Klik <strong>Login</strong></li>
</ol>

<blockquote>Password default dapat diganti oleh Admin melalui menu Manajemen Akun. Hubungi admin jika lupa password.</blockquote>

<h3>Navigasi</h3>
<p>Setelah login, sidebar kiri menampilkan menu Dashboard, KRS, dan KHS. Informasi pengguna dan tombol logout berada di pojok kanan atas header. Sidebar dapat disembunyikan dengan tombol hamburger di pojok kiri atas.</p>
@endsection
