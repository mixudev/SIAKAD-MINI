@extends('docs.layouts.main')
@section('title', 'Manajemen Mahasiswa — SIAKAD Mini')
@section('breadcrumb')
    <span>Admin / Mahasiswa</span>
@endsection
@section('content')
<h2>Manajemen Mahasiswa</h2>

<p>Mengelola data mahasiswa termasuk program studi, angkatan, dan status.</p>

<h3>Data yang Dikelola</h3>
<table>
    <tr><th>Field</th><th>Keterangan</th></tr>
    <tr><td>NIM</td><td>Nomor Induk Mahasiswa (unique)</td></tr>
    <tr><td>Nama Lengkap</td><td>Nama mahasiswa</td></tr>
    <tr><td>Program Studi</td><td>Sistem Informasi / Teknik Informatika / Manajemen</td></tr>
    <tr><td>Angkatan</td><td>Tahun masuk</td></tr>
    <tr><td>Jenis Kelamin</td><td>L / P</td></tr>
    <tr><td>Status</td><td>Aktif / Cuti / Mengundurkan Diri / Lulus</td></tr>
</table>

<h3>Cara Tambah Mahasiswa</h3>
<ol>
    <li>Buka menu <strong>Mahasiswa</strong></li>
    <li>Klik <strong>Tambah Mahasiswa</strong></li>
    <li>Isi data (sistem otomatis buat akun login dengan NIM sebagai identifier)</li>
    <li>Klik <strong>Simpan</strong></li>
</ol>

<h3>Fitur Lain</h3>
<ul>
    <li><strong>Detail</strong> — Informasi lengkap termasuk akun terkait</li>
    <li><strong>Edit</strong> — Ubah data mahasiswa</li>
    <li><strong>Hapus</strong> — Hapus data (KRS dan nilai terkait ikut terhapus)</li>
</ul>

<blockquote>Saat tambah mahasiswa, sistem otomatis membuat akun login dengan NIM sebagai identifier dan password default.</blockquote>
@endsection
