@extends('docs.layouts.main')
@section('title', 'Manajemen Mata Kuliah — SIAKAD Mini')
@section('breadcrumb')
    <span>Admin / Mata Kuliah</span>
@endsection
@section('content')
<h2>Manajemen Mata Kuliah</h2>

<p>Mengelola data mata kuliah yang tersedia di sistem.</p>

<h3>Data yang Dikelola</h3>
<table>
    <tr><th>Field</th><th>Keterangan</th></tr>
    <tr><td>Kode MK</td><td>Kode unik (contoh: SI101, TI102)</td></tr>
    <tr><td>Nama</td><td>Nama mata kuliah</td></tr>
    <tr><td>SKS</td><td>Bobot SKS (biasanya 2—4)</td></tr>
    <tr><td>Program Studi</td><td>Prodi penyelenggara</td></tr>
    <tr><td>Semester</td><td>Semester ideal kurikulum (1—8)</td></tr>
</table>

<h3>Cara Tambah Mata Kuliah</h3>
<ol>
    <li>Buka menu <strong>Mata Kuliah</strong></li>
    <li>Klik <strong>Tambah Mata Kuliah</strong></li>
    <li>Isi kode, nama, SKS, prodi, dan semester ideal</li>
    <li>Klik <strong>Simpan</strong></li>
</ol>

<blockquote>Kode mata kuliah harus unik. SKS menentukan bobot perhitungan IPK.</blockquote>
@endsection
