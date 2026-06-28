@extends('docs.layouts.main')
@section('title', 'Dashboard Admin — SIAKAD Mini')
@section('breadcrumb')
    <span>Admin / Dashboard</span>
@endsection
@section('content')
<h2>Dashboard Admin</h2>

<p>Ringkasan data akademik menyeluruh dalam kartu statistik, grafik, dan tabel KRS pending.</p>

<h3>Kartu Statistik</h3>
<table>
    <tr><th>Kartu</th><th>Fungsi</th></tr>
    <tr><td>Total Mahasiswa</td><td>Jumlah seluruh mahasiswa terdaftar</td></tr>
    <tr><td>Total Dosen</td><td>Jumlah seluruh dosen terdaftar</td></tr>
    <tr><td>Total Mata Kuliah</td><td>Jumlah mata kuliah tersedia</td></tr>
    <tr><td>KRS Pending</td><td>Jumlah KRS menunggu persetujuan</td></tr>
</table>

<h3>Grafik</h3>
<h4>Grafik Garis — Tren Pengajuan KRS (30 Hari)</h4>
<p>Jumlah KRS diajukan per hari selama 30 hari terakhir.</p>

<h4>Grafik Batang — Distribusi Nilai</h4>
<p>Sebaran nilai huruf (A, A-, B+, ... E) dari seluruh mahasiswa.</p>

<h4>Grafik Donat — Mahasiswa per Program Studi</h4>
<p>Komposisi mahasiswa berdasarkan prodi (Sistem Informasi, Teknik Informatika, Manajemen).</p>

<h3>Tabel KRS Pending</h3>
<p>5 KRS terbaru yang menunggu persetujuan:</p>
<table>
    <tr><th>Kolom</th><th>Keterangan</th></tr>
    <tr><td>Mahasiswa</td><td>Nama dan NIM</td></tr>
    <tr><td>Semester</td><td>Semester diajukan</td></tr>
    <tr><td>Total SKS</td><td>SKS yang diajukan</td></tr>
    <tr><td>Tanggal</td><td>Tanggal pengajuan</td></tr>
    <tr><td>Aksi</td><td>Setujui / Tolak (via modal detail)</td></tr>
</table>

<blockquote>Data dashboard bersifat real-time, selalu update saat ada perubahan data.</blockquote>
@endsection
