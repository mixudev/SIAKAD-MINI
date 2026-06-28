@extends('docs.layouts.main')
@section('title', 'Manajemen Kelas Matkul — SIAKAD Mini')
@section('breadcrumb')
    <span>Admin / Kelas Matkul</span>
@endsection
@section('content')
<h2>Manajemen Kelas Mata Kuliah</h2>

<p>Mengelola kelas perkuliahan. Satu mata kuliah bisa memiliki beberapa kelas (paralel) dengan dosen dan jadwal berbeda.</p>

<h3>Data yang Dikelola</h3>
<table>
    <tr><th>Field</th><th>Keterangan</th></tr>
    <tr><td>Mata Kuliah</td><td>Mata kuliah yang dibuka</td></tr>
    <tr><td>Dosen</td><td>Dosen pengampu</td></tr>
    <tr><td>Semester</td><td>Semester kelas berlangsung</td></tr>
    <tr><td>Nama Kelas</td><td>Label kelas (A, B, C, dll)</td></tr>
    <tr><td>Kapasitas</td><td>Maksimal mahasiswa</td></tr>
    <tr><td>Hari</td><td>Hari perkuliahan</td></tr>
    <tr><td>Jam Mulai / Selesai</td><td>Waktu perkuliahan</td></tr>
    <tr><td>Ruangan</td><td>Lokasi kelas</td></tr>
</table>

<h3>Cara Tambah Kelas</h3>
<ol>
    <li>Buka menu <strong>Kelas Matkul</strong></li>
    <li>Klik <strong>Tambah Kelas</strong></li>
    <li>Pilih mata kuliah, dosen, isi nama kelas dan kapasitas</li>
    <li>Atur jadwal (hari, jam mulai/selesai, ruangan)</li>
    <li>Klik <strong>Simpan</strong></li>
</ol>

<blockquote>Mahasiswa hanya bisa memilih kelas yang masih punya kuota. Jadwal digunakan untuk validasi tabrakan saat KRS.</blockquote>
@endsection
