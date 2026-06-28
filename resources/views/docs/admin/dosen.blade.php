@extends('docs.layouts.main')
@section('title', 'Manajemen Dosen — SIAKAD Mini')
@section('breadcrumb')
    <span>Admin / Dosen</span>
@endsection
@section('content')
<h2>Manajemen Dosen</h2>

<p>Mengelola data dosen termasuk informasi pribadi dan akademik.</p>

<h3>Data yang Dikelola</h3>
<table>
    <tr><th>Field</th><th>Keterangan</th></tr>
    <tr><td>NIDN</td><td>Nomor Induk Dosen Nasional (unique)</td></tr>
    <tr><td>Nama Lengkap</td><td>Nama dosen</td></tr>
    <tr><td>Program Studi</td><td>Prodi asal dosen</td></tr>
    <tr><td>Jenis Kelamin</td><td>L / P</td></tr>
</table>

<h3>Cara Tambah Dosen</h3>
<ol>
    <li>Buka menu <strong>Dosen</strong></li>
    <li>Klik <strong>Tambah Dosen</strong></li>
    <li>Isi data (sistem otomatis buat akun login dengan NIDN sebagai identifier)</li>
    <li>Klik <strong>Simpan</strong></li>
</ol>

<h3>Fitur Lain</h3>
<ul>
    <li><strong>Detail</strong> — Informasi lengkap dosen dan akun</li>
    <li><strong>Edit</strong> — Ubah data dosen</li>
    <li><strong>Hapus</strong> — Hapus data dosen</li>
</ul>

<blockquote>Saat tambah dosen, sistem otomatis membuat akun login dengan NIDN sebagai identifier dan password default.</blockquote>
@endsection
