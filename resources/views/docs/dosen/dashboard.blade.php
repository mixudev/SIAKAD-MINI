@extends('docs.layouts.main')
@section('title', 'Dashboard Dosen — SIAKAD Mini')
@section('breadcrumb')
    <span>Dosen / Dashboard</span>
@endsection
@section('content')
<h2>Dashboard Dosen</h2>

<p>Dashboard menampilkan ringkasan aktivitas perkuliahan dan progress penilaian untuk kelas yang diampu.</p>

<h3>Kartu Statistik</h3>
<table>
    <tr><th>Kartu</th><th>Fungsi</th></tr>
    <tr><td>Kelas Diampu</td><td>Jumlah kelas yang diajar di semester aktif</td></tr>
    <tr><td>Mahasiswa Bimbingan</td><td>Total mahasiswa di semua kelas yang diampu</td></tr>
    <tr><td>Progress Input</td><td>Persentase mahasiswa yang sudah dinilai</td></tr>
</table>

<h3>Grafik</h3>
<h4>Grafik Batang Horizontal — Rata-rata NA per Kelas</h4>
<p>Menampilkan rata-rata Nilai Akhir (NA) setiap kelas. Setiap batang mewakili satu kelas. Berguna membandingkan performa antar kelas.</p>

<h4>Grafik Donat — Progress Input Nilai</h4>
<p>Menampilkan perbandingan mahasiswa sudah dinilai (terisi) vs belum (kosong). Persentase terlihat di tengah donat.</p>

<h3>Tabel Kelas Diampu</h3>
<table>
    <tr><th>Kolom</th><th>Keterangan</th></tr>
    <tr><td>Mata Kuliah</td><td>Nama mata kuliah dan kelas</td></tr>
    <tr><td>Jadwal</td><td>Hari, jam, ruangan</td></tr>
    <tr><td>Jumlah Mahasiswa</td><td>Total peserta kelas</td></tr>
    <tr><td>Sudah Dinilai</td><td>Jumlah sudah mendapat nilai</td></tr>
    <tr><td>Progress</td><td>Progress bar persentase</td></tr>
    <tr><td>Aksi</td><td>Tombol menuju halaman input nilai</td></tr>
</table>
@endsection
