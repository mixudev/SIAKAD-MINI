@extends('docs.layouts.main')
@section('title', 'Dosen — SIAKAD Mini')
@section('breadcrumb')
    <span>Dosen</span>
@endsection
@section('content')
<h2>Panduan Dosen</h2>

<p>Dosen dapat mengakses Dashboard dan mengelola nilai mata kuliah yang diampu. Setelah login, sistem mengarahkan ke dashboard dosen.</p>

<h3>Fitur Tersedia</h3>
<table>
    <tr><th>Menu</th><th>Fungsi</th></tr>
    <tr><td>Dashboard</td><td>Ringkasan kelas diampu, progress input nilai, grafik rata-rata NA</td></tr>
    <tr><td>Nilai</td><td>Input dan edit nilai untuk kelas yang diampu</td></tr>
</table>

<h3>Cara Login</h3>
<ol>
    <li>Buka halaman login sistem</li>
    <li>Masukkan <strong>NIDN</strong> sebagai identifier (contoh: <code>0510017801</code>)</li>
    <li>Masukkan password (default: <code>password</code>)</li>
    <li>Klik <strong>Login</strong></li>
</ol>

<blockquote>Password default dapat diganti oleh Admin. Hubungi admin jika lupa password.</blockquote>

<h3>Navigasi</h3>
<p>Sidebar kiri menampilkan menu Dashboard dan Nilai. Gunakan menu Nilai untuk menginput nilai mahasiswa per kelas. Informasi pengguna dan logout di pojok kanan atas header.</p>
@endsection
