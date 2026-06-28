@extends('docs.layouts.main')
@section('title', 'Overview Nilai — SIAKAD Mini')
@section('breadcrumb')
    <span>Admin / Nilai</span>
@endsection
@section('content')
<h2>Overview Nilai</h2>

<p>Ringkasan nilai seluruh mahasiswa per semester dan per kelas. Admin dapat memantau progress penilaian dosen.</p>

<h3>Filter Data</h3>
<ul>
    <li><strong>Filter Semester</strong> — Pilih semester</li>
    <li><strong>Filter Kelas</strong> — Pilih kelas mata kuliah (opsional)</li>
</ul>
<p>Klik <strong>Tampilkan</strong> untuk memperbarui tabel.</p>

<h3>Tabel Nilai</h3>
<table>
    <tr><th>Kolom</th><th>Keterangan</th></tr>
    <tr><td>Mahasiswa</td><td>NIM dan nama</td></tr>
    <tr><td>Mata Kuliah</td><td>Kode dan nama MK</td></tr>
    <tr><td>Kelas</td><td>Nama kelas</td></tr>
    <tr><td>Dosen</td><td>Dosen pengampu</td></tr>
    <tr><td>Tugas</td><td>Nilai tugas</td></tr>
    <tr><td>UTS</td><td>Nilai UTS</td></tr>
    <tr><td>UAS</td><td>Nilai UAS</td></tr>
    <tr><td>NA</td><td>Nilai Akhir (otomatis)</td></tr>
    <tr><td>NH</td><td>Nilai Huruf</td></tr>
</table>

<h3>Kegunaan</h3>
<ul>
    <li>Memantau progress dosen menginput nilai</li>
    <li>Memeriksa kelengkapan nilai mahasiswa</li>
    <li>Melihat distribusi nilai keseluruhan</li>
</ul>

<blockquote>Nilai hanya bisa diinput oleh dosen pengampu masing-masing kelas. Admin tidak bisa mengedit nilai langsung.</blockquote>
@endsection
